<template>
    <div>
        <div class="col-md-12">
            <h3>{{ lang.all_modules }}</h3>
            <el-collapse v-model="activeCollapseItem">
                <template v-for="(element,key) in modules">
                    <el-collapse-item :name="element.key">
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
                            </div>
                            <el-tabs v-model="element.activeLocaleKey">
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
                                                                   v-model="modules[key].inputs[fieldKey].locales[locale]">
                                                        </template>
                                                        <template v-else>
                                                            <input type="text" class="form-control"
                                                                   :disabled="loading"
                                                                   v-model="modules[key].inputs[fieldKey].value">
                                                        </template>
                                                    </template>
                                                    <template v-if="field.type == 'textarea'">
                                                        <template v-if="field.is_translation">
                                                            <textarea rows="10" type="text" class="form-control"
                                                                      :disabled="loading"
                                                                      v-model="modules[key].inputs[fieldKey].locales[locale]"></textarea>
                                                        </template>
                                                        <template v-else>
                                                            <textarea rows="10" type="text" class="form-control"
                                                                      :disabled="loading"
                                                                      v-model="modules[key].inputs[fieldKey].value"></textarea>
                                                        </template>
                                                    </template>
                                                    <template v-if="field.type == 'wysiwig'">
                                                        <template v-if="field.is_translation">
                                                            <ckeditor
                                                                :key="key + fieldKey"
                                                                :editor="editor"
                                                                :config="editorConfigData"
                                                                v-model="modules[key].inputs[fieldKey].locales[locale]">
                                                            </ckeditor>
                                                        </template>
                                                        <template v-else>
                                                            <ckeditor :editor="editor"
                                                                      :config="editorConfigData"
                                                                      v-model="modules[key].inputs[fieldKey].value">
                                                            </ckeditor>
                                                        </template>
                                                    </template>

                                                    <template v-if="field.type == 'multi_fields'">
                                                        <MultiFields
                                                            :updateData="updateElementData"
                                                            :lang="lang"
                                                            :upload-image-route="routes.upload_image"
                                                            :locales="locales"
                                                            :default-locale="defaultLocale"
                                                            :module-name="key"
                                                            :field-key="fieldKey"
                                                            :item="field">
                                                        </MultiFields>
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

                                                    <template v-if="field.type == 'multi_image'">
                                                        <MultiImageUpload
                                                            :formData="{}"
                                                            :field="field"
                                                            :updateData="updateElementData"
                                                            :lang="lang"
                                                            :upload-image-route="routes.upload_image"
                                                            :locales="locales"
                                                            :default-locale="defaultLocale"
                                                            :module-name="key"
                                                            :field-key="fieldKey"
                                                            :item="field">
                                                        </MultiImageUpload>
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
            </el-collapse>
        </div>
    </div>
</template>
<script>
import draggable from "vuedraggable";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import MultiImageUpload from "../../../components/admin/Gallery/MultiImageUpload";
import MyUploadAdapter from '../../../mixins/EditorCustomUpload';
import MultiFields from "../../../components/admin/RepeatFields/MultiFields";
import {getData} from "@/base/mixins/getData";
import {responseParse} from "@/base/mixins/responseParse";

export default {
    components: {
        MultiFields,
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
            loading: false,
            activeCollapseItem: [
            ],
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
        'item'() {
            if (this.item) {
                this.modules = this.item ? this.item : [];
            }
        },
        'options'() {
            if (this.options && !this.modules.length) {
                Object.keys(this.options.all_modules).forEach((module) => {
                    this.modules.push(this.options.all_modules[module])
                });
            }
        },
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
            if (evt.moved) {
                this.reorderModules(evt.moved.oldIndex, evt.moved.newIndex)
            }
        },
        updateElementData(module, fieldKey, data) {
            if (this.modules instanceof Object) {
                this.modules = Object.keys(this.modules).map((key) => this.modules[key]);
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
                });
        },
        reorderModules(elementKey, replaceElementKey) {
            this.modules.splice(replaceElementKey, 0, this.modules.splice(elementKey, 1)[0]);
        },
        async handleFileUpload(inputId, moduleKey, fieldKey) {
            let file = this.$refs.file.files[0];

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
