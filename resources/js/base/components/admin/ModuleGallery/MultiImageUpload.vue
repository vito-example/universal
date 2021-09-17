<template>
    <div>
        <div>
            <div v-loading="loading"
                    element-loading-text="Loading..."
                    element-loading-spinner="el-icon-loading"
                    element-loading-background="rgba(0, 0, 0, 0)"
                    class="form-horizontal form-bordered row">
                <el-upload
                    action="#"
                    list-type="picture-card"
                    :file-list="fileList"
                    :on-change="handleChange"
                    multiple
                    style="margin-top: 30px;"
                    :auto-upload="false">
                    <i slot="default" class="el-icon-plus" :title="lang.multi_upload"></i>
                    <div slot="file" slot-scope="{file}">
                        <img
                            v-if="file"
                            class="el-upload-list__item-thumbnail"
                            :src="file.url" alt="">
                        <span class="el-upload-list__item-actions">
                        <span
                            class="el-upload-list__item-preview"
                            @click="handlePictureCardPreview(file)"
                        >
                      <i class="el-icon-zoom-in"></i>
                    </span>
                  </span>
                    </div>
                </el-upload>

                <draggable tag="div" v-model="form.images" handle=".handle">
                    <template #item="{element,idx}">
                        <div class="padding-t col-md-4 col-sm-6 module-images">

                        <div class="block">

                            <el-button
                                :title="lang.image_drag"
                                size="small"
                                type="info is-plain"
                                icon="el-icon-sort"
                                class="handle">
                            </el-button>

                            <el-button
                                v-if="field.additional_fields"
                                @click="showEditImage(element)"
                                :title="lang.image_edit"
                                size="small"
                                type="primary"
                                icon="el-icon-edit">
                            </el-button>

                            <el-button
                                @click="removeImage(element)"
                                :title="lang.image_delete"
                                size="small"
                                type="danger"
                                icon="el-icon-delete">
                            </el-button>

                            <el-row :gutter="20">
                                <el-col :sm="24" :span="24" class="padding-tb">
                                    <div style="height: 200px; overflow: hidden;">
                                        <img :src="element.url" style="width: 100%;">
                                    </div>
                                    <span>{{ element[fieldKey] ? element[fieldKey].title : '' }}</span>
                                </el-col>
                            </el-row>

                        </div>

                    </div>
                    </template>
                    <div style="clear: left;"></div>
                </draggable>

                <template v-if="dialogVisible">
                    <div>
                        <el-drawer
                            v-loading="loading"
                            element-loading-text="Loading..."
                            element-loading-spinner="el-icon-loading"
                            element-loading-background="rgba(0, 0, 0, 0)"
                            :title="lang.add_image"
                            v-model="dialogVisible"
                            size="60%"
                            direction="rtl"
                            custom-class="demo-drawer"
                            ref="drawer"
                            :before-close="handleClose">
                            <div class="demo-drawer__content">
                                <el-tabs v-model="activeTabName" v-if="field.additional_fields">
                                    <template v-for="(locale,localeKey) in locales">

                                        <el-tab-pane class="" :label="locale" :name="locale">
                                            <template v-for="(field,index) in edit_data.additional_fields">
                                                <div class="form-group popup"
                                                     v-if="field.is_translation || (!field.is_translation && localeKey == 0)">
                                                    <label class="col-md-2 control-label">{{ field.label }}
                                                        {{ field.is_translation ? locale : '' }}
                                                        <template v-if="field.is_required">
                                                            <span class="text-danger">*</span>:
                                                        </template>
                                                    </label>
                                                    <div class="col-md-10">
                                                        <template v-if="field.type == 'text'">
                                                            <template v-if="field.is_translation">
                                                                <input class="form-control"
                                                                    :disabled="loading"
                                                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                                                    v-model="image_form.additional_fields[index].locales[locale]">
                                                            </template>
                                                            <template v-else>
                                                                <input class="form-control"
                                                                    :disabled="loading"
                                                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                                                    v-model="image_form.additional_fields[index].value">
                                                            </template>
                                                        </template>

                                                        <template v-else-if="field.type == 'textarea'">
                                                            <template v-if="field.is_translation">
                                                                <textarea type="textarea" class="form-control" :disabled="loading"
                                                                          :placeholder="field.placeholder ? field.placeholder : ''"
                                                                          v-model="image_form.additional_fields[index].locales[locale]"></textarea>
                                                            </template>
                                                            <template v-else>
                                                                <textarea type="textarea" class="form-control" :disabled="loading"
                                                                          :placeholder="field.placeholder ? field.placeholder : ''"
                                                                          v-model="image_form.additional_fields[index].value"></textarea>
                                                            </template>
                                                        </template>

                                                        <template v-else-if="field.type == 'wysiwig'">
                                                            <template v-if="field.is_translation">
                                                                <ckeditor
                                                                    :editor="editor"
                                                                    v-model="image_form.additional_fields[index].locales[locale]">
                                                                </ckeditor>
                                                            </template>
                                                            <template v-else>
                                                                <ckeditor
                                                                    :editor="editor"
                                                                    v-model="image_form.additional_fields[index].value">
                                                                </ckeditor>
                                                            </template>
                                                        </template>

                                                        <template v-else-if="field.type == 'select'">
                                                            <template v-if="field.is_translation">
                                                                <el-select
                                                                    :placeholder="field.label"
                                                                    v-model="image_form.additional_fields[index].locales[locale]"
                                                                    clearable
                                                                    filterable>
                                                                    <el-option
                                                                        v-for="(item,key) in field.options"
                                                                        :key="key"
                                                                        :label="item.label"
                                                                        :value="item.value">
                                                                    </el-option>
                                                                </el-select>
                                                            </template>
                                                            <template v-else>
                                                                <el-select
                                                                    :placeholder="field.label"
                                                                    v-model="image_form.additional_fields[index].value"
                                                                    clearable
                                                                    filterable>
                                                                    <el-option
                                                                        v-for="(item,key) in field.options"
                                                                        :key="key"
                                                                        :label="item.label"
                                                                        :value="item.value">
                                                                    </el-option>
                                                                </el-select>
                                                            </template>
                                                        </template>

                                                        <template v-else-if="field.type == 'image'">
                                                            <template v-if="!field.is_translation">
                                                                <input style="display: block !important;"
                                                                       :id="'image_' + index" :ref="'image_' + index" type="file"
                                                                       v-on:change="handleFieldFileUpload(index,field)"/>
                                                                <template v-if="field.image">
                                                                    <img :src="field.image.full_src"
                                                                         style="width: 100%;">
                                                                </template>

                                                            </template>
                                                        </template>

                                                    </div>

                                                </div>
                                            </template>

                                            <div class="form-group">

                                                <label class="col-md-2 control-label">{{ lang.image_url }}<span
                                                    class="text-danger">*</span>:</label>
                                                <div class="col-md-6">
                                                    <input style="display: block !important;" id="file" ref="file" type="file"
                                                           v-on:change="handleFileUpload"/>
                                                </div>

                                                <div v-if="image_form.url">
                                                    <div class="col-md-offset-2 col-md-6 padding-t">
                                                        <img :src="image_form.url" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        </el-tab-pane>

                                    </template>
                                </el-tabs>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="demo-drawer__footer">
                                            <el-button size="medium" type="info is-plain" @click="modal(false)">{{ lang.close_image }}
                                            </el-button>
                                            <el-button size="medium" type="primary is-plain" icon="el-icon-check" @click="saveimage"
                                                       :disabled="loading" :loading="loading">{{ lang.save_image }}
                                            </el-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </el-drawer>
                    </div>

<!--                    <AddImageComponent-->
<!--                        :item_field="field.additional_fields"-->
<!--                        v-if="showModal"-->
<!--                        :formData="formData"-->
<!--                        :updateImageData="updateImageData"-->
<!--                        :lang="lang"-->
<!--                        :upload_image_route="uploadImageRoute"-->
<!--                        :locales="locales"-->
<!--                        :edit_data="edit_data"-->
<!--                        :default_locale="defaultLocale">-->
<!--                    </AddImageComponent>-->

                </template>
            </div>
        </div>
    </div>
</template>

<style>
.block .el-upload__input {
    display: none;
}
</style>

<script>
import draggable from "vuedraggable";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import MyUploadAdapter from '../../../mixins/EditorCustomUpload';
import {responseParse} from "@/base/mixins/responseParse";
import {getData} from "@/base/mixins/getData";
import { nextTick } from 'vue'
import Textarea from "@/CoreUi/components/Textarea";

export default {
    components: {Textarea, draggable},
    props: [
        'field',
        'formData',
        'updateData',
        'lang',
        'uploadImageRoute',
        'locales',
        'defaultLocale',
        'moduleName',
        'old_data',
        'options',
        'item',
        'fieldKey'
    ],
    watch: {
        item() {
            if (this.item) {
                this.form = this.item
            }
        }
    },
    data() {
        return {
            activeTabName: 'ka',
            dialogVisible: false,
            loading: false,
            form: {
                images: []
            },
            editor: ClassicEditor,
            showModal: false,

            dialogImageUrl: '',
            disabled: false,
            fileList: [],
            edit_data: {},
            image_form: {},
        }
    },
    created() {
        if (this.item) {
            this.form = this.item
        }
    },
    updated() {
        this.updateData(this.moduleName, this.fieldKey, this.form);
    },

    methods: {
        handleRemove(file) {
            this.fileList = this.fileList.filter(function (item) {
                return item.uid != file.uid;
            });
        },
        handlePictureCardPreview(file) {
            this.dialogImageUrl = file ? file.url : '';
            this.dialogVisible = true;
        },
        showAdd() {
            this.edit_data = undefined;
            this.image_form = this.edit_data;
            this.forceRerender(true);
        },

        getKeyFromElements(element){
            var index = ''
            this.form.images.forEach((item, key) => {
                if (!index && item.index === element.index) {
                    index = key
                }
            })
            return index
        },
        showEditImage(element) {
            var index = this.getKeyFromElements(element)
            this.edit_data = '';
            this.form.images[index].index = index;
            this.edit_data = Object.assign({}, JSON.parse(JSON.stringify(this.form.images[index])));
            this.image_form = this.edit_data;
            this.forceRerender(true);
        },
        removeImage(element) {
            var index = this.getKeyFromElements(element)
            this.$confirm(this.lang.remove_image_confirm, {
                confirmButtonText: this.lang.remove_image_confirm_yes,
                cancelButtonText: this.lang.remove_image_confirm_no,
                type: 'warning'
            })
                .then(async () => {
                    this.form.images = this.form.images.filter((item, i) => {
                        return i != index;
                    });
                });
        },

        /**
         *
         * @param data
         */
        updateImageData(data = undefined, index = '') {
            if (data && !data.inputs) {
                data.inputs = this.field.inputs;
            }

            if (data && index !== '') {
                if (!data.id) {
                    data.id = Date.now()
                }
                this.form.images[index] = data;
            } else if (data) {
                data.additional_fields = this.form.additional_fields
                if (!data.id) {
                    data.id = Date.now()
                }
                this.form.images.push(data);
            } else {
                let oldData = this.form;
                this.form = {};
                this.form = oldData;
            }

            this.updateData(this.moduleName, this.fieldKey, this.form);
        },

        forceRerender(showComponent = false) {
            this.dialogVisible = !showComponent;
            nextTick(() => {
                this.dialogVisible = showComponent;
            });
        },

        /**
         *
         * @param items
         * @param locale
         */
        getTranslationItem(items, locale) {
            let searchItem = {};
            items.forEach((item) => {
                if (item.locale == locale) {
                    searchItem = item;
                }
            });
            return searchItem;
        },
        /**
         *
         * @param done
         */
        handleClose(done) {
            this.updateImageData();
            done();
        },

        /**
         * Save image data.
         */
        saveimage() {
            // return;
            let data = Object.assign({}, this.image_form);
            this.updateImageData(data, this.image_form ? this.image_form.index : '');
            this.modal(false);
        },
        modal(status = true) {
            if (!status) {
                this.updateImageData();
            }
            this.dialogVisible = status;
        },
        /**
         * File upload.
         */
        async handleFileUpload() {
            console.log(this.$refs)
            let file = this.$refs.file.files[0];
            this.image_form = {...this.image_form, ...{url: URL.createObjectURL(file)}};
            var data = new FormData();
            data.append('file', file);
            data.append('type', 'gallery_image');

            this.fileUpload(data).then((response) => {
                this.image_form.image_id = response.id;
                this.image_form.url = response.full_src;
            })
        },
        async handleFieldFileUpload(index, field) {
            let file = this.$refs['image_' + index].files[0];

            var data = new FormData();
            data.append('file', file);
            data.append('type', 'custom_field_' + field.name);

            this.fileUpload(data).then((response) => {
                this.image_form.additional_fields[index].image = {...this.image_form.additional_fields[index].image, ...response}
                this.modules[moduleKey].inputs[fieldKey].image = {...this.modules[moduleKey].inputs[fieldKey], ...response}
            })
        },
        async handleChange(file, fileList) {
            let fileItem = file.raw;
            var data = new FormData();
            data.append('file', fileItem);
            data.append('type', 'gallery_image');

            this.fileUpload(data).then((response) => {
                this.updateImageData({
                    image_id: response.id,
                    url: response.full_src
                });
            })
            this.fileList = [];
        },

        /**
         *
         * @param requestData
         * @returns {Promise<*>}
         */
        async fileUpload (requestData) {
            this.loading = true
            var responseData;
            await getData({
                method: 'POST',
                url: this.uploadImageRoute,
                data: requestData
            }).then(response => {
                responseParse(response);
                if (response.status === 200) {
                    let data = response.data;
                    responseData = data.item
                }
                this.loading = false
            });

            return responseData
        }

    }

}

</script>
