<template>
    <div>
        <div class="row">
            <div class="col-md-2">
                <h3>{{ lang.select_modules }}</h3>
                <template v-if="allModules.length">
                    <draggable
                        class="dragArea list-group"
                        v-model="allModules"
                        :group="{ name: 'people', pull: 'clone', put: false }">
                        <template #item="{element,key}">
                            <div class="list-group-item" style="display: flex; justify-content: space-between;">
                                <span>
                                {{ element.label }}
                                </span>
                                <i class="el-icon-sort"></i>
                            </div>
                        </template>
                    </draggable>
                </template>
            </div>

            <div class="col-md-10">
                <h3>{{ lang.all_modules }}</h3>
                <el-collapse v-model="activeCollapseItem">
                    <draggable
                        class="dragArea list-group"
                        group="people"
                        v-model="modules"
                        @change="updateModules">
                        <template #item="{element,key}">
                            <el-collapse-item :name="k">
                                <template #title>
                                <span>
                                  {{ element.label }}
                                </span>
                                </template>
                                <div class="block block-module" :class="element.key" :key="key" v-if="element">
                                    <div class="form-group module-actions"
                                         style="display:flex; justify-content: space-between;">
                                        <div class="col module-title">
                                            <input type="text" class="form-control"
                                                   :placeholder="lang.module_admin_title"
                                                   :disabled="loading"
                                                   v-model="element.label">
                                        </div>
                                        <div class="col module-radio-small">
                                            <el-radio-group v-model="element.status">
                                                <el-radio-button :label="1">{{ lang.module_enable }}</el-radio-button>
                                                <el-radio-button :label="0">{{ lang.module_disable }}</el-radio-button>
                                            </el-radio-group>
                                        </div>
                                        <div class="col module-buttons">
                                            <el-button type="danger"
                                                       @click="deleteElement(getKeyFromElements(element))"
                                                       size="small"
                                                       icon="el-icon-delete-solid">
                                            </el-button>
                                        </div>
                                    </div>
                                    <el-tabs v-if="element.activeLocaleKey" v-model="element.activeLocaleKey">
                                        <template v-for="(locale,localeKey) in locales">
                                            <el-tab-pane class="" :label="locale" :name="locale">

                                                <template v-for="(field,fieldKey) in element.inputs">

                                                    <div class="form-group row"
                                                         v-if="field.is_translation || (!field.is_translation && localeKey == 0)">
                                                        <label class="col-md-1 control-label">
                                                            <template v-if="field.is_required">
                                                                <span class="text-danger">*</span>
                                                            </template>
                                                            {{ field.label }}
                                                        </label>
                                                        <div class="col-md-10">
                                                            <template v-if="field.type == 'text'">
                                                                <template v-if="field.is_translation">
                                                                    <input type="text" class="form-control"
                                                                           :disabled="loading"
                                                                           v-model="modules[getKeyFromElements(element)].inputs[fieldKey].locales[locale]">
                                                                </template>
                                                                <template v-else>
                                                                    <input type="text" class="form-control"
                                                                           :disabled="loading"
                                                                           v-model="modules[getKeyFromElements(element)].inputs[fieldKey].value">
                                                                </template>
                                                            </template>
                                                            <template v-if="field.type == 'wysiwig'">
                                                                <template v-if="field.is_translation">
                                                                    <ckeditor
                                                                        :key="getKeyFromElements(element) + fieldKey"
                                                                        :editor="editor"
                                                                        :config="editorConfigData"
                                                                        v-model="modules[getKeyFromElements(element)].inputs[fieldKey].locales[locale]">
                                                                    </ckeditor>
                                                                </template>
                                                                <template v-else>
                                                                    <ckeditor :editor="editor"
                                                                              :config="editorConfigData"
                                                                              v-model="modules[getKeyFromElements(element)].inputs[fieldKey].value">
                                                                    </ckeditor>
                                                                </template>
                                                            </template>

                                                            <template v-if="field.type == 'multi_files'">
                                                                <MultiFileUpload
                                                                    :formData="{}"
                                                                    :field="field"
                                                                    :updateData="updateElementData"
                                                                    :lang="lang"
                                                                    :upload-image-route="routes.upload_image"
                                                                    :locales="locales"
                                                                    :default-locale="defaultLocale"
                                                                    :module-name="getKeyFromElements(element)"
                                                                    :field-key="fieldKey"
                                                                    :item="field">
                                                                </MultiFileUpload>
                                                            </template>

                                                            <template v-if="field.type == 'multi_fields'">
                                                                <MultiFields
                                                                    :updateData="updateElementData"
                                                                    :lang="lang"
                                                                    :upload-image-route="routes.upload_image"
                                                                    :locales="locales"
                                                                    :default-locale="defaultLocale"
                                                                    :module-name="getKeyFromElements(element)"
                                                                    :field-key="fieldKey"
                                                                    :item="field">
                                                                </MultiFields>
                                                            </template>

                                                            <template v-if="field.type == 'multi_image'">
                                                                <MultiImageUpload
                                                                    :formData="{}"
                                                                    :field="field"
                                                                    :updateData="updateElementData"
                                                                    :lang="lang"
                                                                    :upload-image-route="routes.upload_image"
                                                                    :locales="locales"
                                                                    :default-locale="defaultLocale"
                                                                    :module-name="getKeyFromElements(element)"
                                                                    :field-key="fieldKey"
                                                                    :item="field">
                                                                </MultiImageUpload>
                                                            </template>

                                                            <template v-if="field.type == 'image'">
                                                                <input style="display: block !important;"
                                                                       :id="'image_' + key" ref="file" type="file"
                                                                       v-on:change="handleFileUpload('image_' + key,key,fieldKey)"/>
                                                                <template v-if="field.image">
                                                                    <img :src="field.image.full_src"
                                                                         style="width: 100%;">
                                                                </template>
                                                            </template>
                                                        </div>
                                                    </div>

                                                </template>

                                            </el-tab-pane>
                                        </template>
                                    </el-tabs>
                                </div>
                            </el-collapse-item>
                        </template>
                    </draggable>
                </el-collapse>
            </div>
        </div>
    </div>
</template>
<script>
import MultiFileUpload from "../../../components/admin/ModuleFiles/MultiFileUpload";
import draggable from "vuedraggable";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import MyUploadAdapter from '../../../mixins/EditorCustomUpload';

import {responseParse} from "@/base/mixins/responseParse";
import {getData} from "@/base/mixins/getData";
import MultiImageUpload from "@/base/components/admin/ModuleGallery/MultiImageUpload";
import MultiFields from "@/base/components/admin/RepeatFields/MultiFields";

export default {
    components: {
        draggable,
        MultiFileUpload,
        MultiImageUpload,
        MultiFields,
    },

    props: [
        'lang',
        'locales',
        'defaultLocale',
        'routes',
        'updateData',
        'item',
        'options',
        'editorConfig'
    ],
    data() {
        return {
            editor: ClassicEditor,
            modules: [],
            loading: false,
            test: [],
            activeCollapseItem: [],
            editorConfigData: {},
            allModules: []
        }
    },
    watch: {
        'editorConfig'() {
            if (this.editorConfig) {
                this.editorConfigData = this.editorConfig;
                this.editorConfigData.extraPlugins = [this.meyCustomUploadAdapterPlugin];
            }
        },
        'options'() {
            if (this.options) {
                this.allModules = this.options.all_modules.map((item) => {
                    return {
                        key: item.key,
                        label: item.label
                    }
                })
            }
        },
        'item'() {
            if (this.item && !this.modules.length) {
                if (typeof this.item === 'object' && this.item !== null) {
                    this.modules = Object.values(this.item);
                } else {
                    this.modules = this.item;
                }
            }
        }
    },
    created() {
        if (this.item) {
            this.modules = this.item;
        }
    },
    updated() {
        this.updateData('meta', this.modules);
    },
    methods: {
        meyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };

        },
        async updateModules(evt) {
            if (evt.moved) {
                this.updateData('meta', this.modules);
                // this.reorderModules(evt.moved.oldIndex, evt.moved.newIndex)
            }
            if (evt.added) {
                var element = null;
                await this.options.all_modules.map((item,key) => {
                    if(!element && evt.added.element.key === item.key) {
                        element = Object.assign({}, JSON.parse(JSON.stringify(this.options.all_modules[key])));
                    }
                })
                this.modules[evt.added.newIndex] = element
            }
        },
        getKeyFromElements(element){
            var index = ''
            this.modules.forEach((item, key) => {
                if (!index && item.id === element.id) {
                    index = key
                }
            })
            return index
        },
        updateElementData(module, fieldKey, data) {
            if (data && !data.id) {
                data.id = Date.now()
            }
            if (!this.modules[module] || !this.modules[module].status) {
                return
            }
            if (!this.modules[module]){
                this.modules[module] = {
                    inputs: []
                }
            } else if (!this.modules[module].inputs || !this.modules[module].inputs[fieldKey]) {
                this.modules[module].inputs = {}
            }
            if (this.modules[module] && !this.modules[module].id) {
                this.modules[module].id = Date.now()
            }
            this.modules[module].inputs[fieldKey] = data
        },
        deleteElement(elementKey) {
            this.$confirm(this.lang.remove_module_confirm, {
                confirmButtonText: this.lang.remove_module_confirm_yes,
                cancelButtonText: this.lang.remove_module_confirm_no,
                type: 'warning'
            })
                .then(async () => {
                    this.modules = this.modules.filter((element, key) => {
                        return key != elementKey
                    })
                    this.updateData('meta', this.modules);
                });
        },
        reorderModules(elementKey, replaceElementKey) {
            if (this.modules instanceof Object) {
                this.modules = Object.keys(this.modules).map((key) => this.modules[key]);
            }

            this.modules.splice(replaceElementKey, 0, this.modules.splice(elementKey, 1)[0]);
        },
        async handleFileUpload(inputId, moduleKey, fieldKey) {
            let file = this.$refs.file.files[0].filter((fileItem, index) => {
                return fileItem.id == inputId;
            })[0].files[0];

            var data = new FormData();
            data.append('file', file);
            data.append('type', inputId);

            await getData({
                method: 'POST',
                url: this.routes.upload_image,
                data: data
            }).then(response => {
                // Parse response notification.
                responseParse(response);
                if (response.status == 200) {
                    this.modules[moduleKey].inputs[fieldKey].image = {...this.modules[moduleKey].inputs[fieldKey], ...response.data.item}
                }
                this.loading = false
            });
        }
    }
}
</script>
