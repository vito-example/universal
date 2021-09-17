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
                            <div
                                style="display: flex; justify-content: space-between;"
                                :style="element.key.includes('header_') ? 'background-color:#000000; color: #ffffff' : ''"
                                class="list-group-item">
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
                            v-model="modules"
                            group="people"
                            item-key="id"
                            @change="log">
                            <template #item="{element,key}">
                                <el-collapse-item :name="key">
                                <template #title>
                                <span>
                                  {{ element.label }}
                                </span>
                                    <template v-if="element.key.includes('header_')">
                                    </template>
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
                                                       @click="deleteElement(key)"
                                                       size="small"
                                                       icon="el-icon-delete-solid">
                                            </el-button>
                                        </div>
                                    </div>

                                    <el-tabs v-if="element.activeLocaleKey" v-model="element.activeLocaleKey">
                                        <template v-for="(locale,localeKey) in locales">
                                            <el-tab-pane class="" :label="locale" :name="locale">

<!--                                                <template v-for="(field,fieldKey) in element.inputs">-->

<!--                                                    <div class="form-group row"-->
<!--                                                         v-if="field.is_translation || (!field.is_translation && localeKey == 0)">-->
<!--                                                        <label class="col-md-1 control-label">-->
<!--                                                            <template v-if="field.is_required">-->
<!--                                                                <span class="text-danger">*</span>-->
<!--                                                            </template>-->
<!--                                                            {{ field.label }}-->
<!--                                                        </label>-->
<!--                                                        <div class="col-md-10">-->
<!--                                                            <template v-if="field.type == 'text'">-->
<!--                                                                <template v-if="field.is_translation">-->
<!--                                                                    <input type="text" class="form-control"-->
<!--                                                                           :disabled="loading"-->
<!--                                                                           v-model="modules[key].inputs[fieldKey].locales[locale]">-->
<!--                                                                </template>-->
<!--                                                                <template v-else>-->
<!--                                                                    <input type="text" class="form-control"-->
<!--                                                                           :disabled="loading"-->
<!--                                                                           v-model="modules[key].inputs[fieldKey].value">-->
<!--                                                                </template>-->
<!--                                                            </template>-->
<!--                                                            <template v-if="field.type == 'wysiwig'">-->
<!--                                                                <template v-if="field.is_translation">-->
<!--                                                                    <ckeditor-->
<!--                                                                        :key="key + fieldKey"-->
<!--                                                                        :editor="editor"-->
<!--                                                                        :config="editorConfigData"-->
<!--                                                                        v-model="modules[key].inputs[fieldKey].locales[locale]">-->
<!--                                                                    </ckeditor>-->
<!--                                                                </template>-->
<!--                                                                <template v-else>-->
<!--                                                                    <ckeditor :editor="editor"-->
<!--                                                                              :config="editorConfigData"-->
<!--                                                                              v-model="modules[key].inputs[fieldKey].value">-->
<!--                                                                    </ckeditor>-->
<!--                                                                </template>-->
<!--                                                            </template>-->

<!--                                                            <template v-if="field.type == 'multi_image'">-->
<!--                                                                <MultiImageUpload-->
<!--                                                                    :formData="{}"-->
<!--                                                                    :field="field"-->
<!--                                                                    :updateData="updateElementData"-->
<!--                                                                    :lang="lang"-->
<!--                                                                    :upload-image-route="routes.upload_image"-->
<!--                                                                    :locales="locales"-->
<!--                                                                    :default-locale="defaultLocale"-->
<!--                                                                    :module-name="key"-->
<!--                                                                    :field-key="fieldKey"-->
<!--                                                                    :item="field">-->
<!--                                                                </MultiImageUpload>-->
<!--                                                            </template>-->

<!--                                                            <template v-if="field.type == 'image'">-->
<!--                                                                <input style="display: block !important;"-->
<!--                                                                       :id="'image_' + key" ref="file" type="file"-->
<!--                                                                       v-on:change="handleFileUpload('image_' + key,key,fieldKey)"/>-->
<!--                                                                <template v-if="field.image">-->
<!--                                                                    <img :src="field.image.full_src"-->
<!--                                                                         style="width: 100%;">-->
<!--                                                                </template>-->
<!--                                                            </template>-->
<!--                                                        </div>-->
<!--                                                    </div>-->

<!--                                                </template>-->

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
import draggable from "vuedraggable";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import MyUploadAdapter from '../../../mixins/EditorCustomUpload';
import MultiImageUpload from "../../../components/admin/ModuleGallery/MultiImageUpload";
import {responseParse} from "@/base/mixins/responseParse";
import {getData} from "@/base/mixins/getData";

export default {
    components: {
        draggable,
        MultiImageUpload
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
            allModules: [],
            modules: [],
            test: [],
            loading: false,
            activeCollapseItem: [],
            editorConfigData: {}
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
                this.allModules = this.options.all_modules
            }
        },
        'item'() {
            if (this.item) {
                this.modules = this.item;
            }
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
        log(evt) {
            let isHeaderElement = false;
            if (evt.moved) {
                this.reorderModules(evt.moved.oldIndex, evt.moved.newIndex)
            }
            if (evt.added) {
                if (evt.added.element.key.includes('header')) {
                    let existHeader = false;
                    isHeaderElement = true
                    this.modules.forEach((module) => {
                        if (module.key.includes('header')) {
                            existHeader = true;
                        }
                    })
                    if (existHeader) {
                        return;
                    }
                }
                let data = Object.assign({}, JSON.parse(JSON.stringify(evt.added.element)));
                this.modules.push(data);
                this.activeCollapseItem.push(this.modules.length - 1)
            }

            if (isHeaderElement) {
                this.reorderModules(this.modules.length - 1, 0);
                this.activeCollapseItem = [];
                this.activeCollapseItem.push(0)
            }
        },
        updateElementData(module, fieldKey, data) {
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
                });
        },
        reorderModules(elementKey, replaceElementKey) {
            if (this.modules instanceof Object) {
                this.modules = Object.keys(this.modules).map((key) => this.modules[key]);
            }
            this.modules.splice(replaceElementKey, 0, this.modules.splice(elementKey, 1)[0]);
        },
        async handleFileUpload(inputId, moduleKey, fieldKey) {
            let file = this.$refs.file.filter((fileItem, index) => {
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
