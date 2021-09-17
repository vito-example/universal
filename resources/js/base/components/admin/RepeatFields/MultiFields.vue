<template>
    <div>
        <div v-loading="loading"
             element-loading-text="Loading..."
             element-loading-spinner="el-icon-loading"
             element-loading-background="rgba(0, 0, 0, 0)"
             class="row form-horizontal form-bordered">
            <draggable tag="div" v-model="form.fields" handle=".handle" item-key="id">
                <template #item="{element,idx}">
                    <div class="padding-t col-md-4 col-sm-6 module-images">
                        <div class="block">

                            <el-button
                                size="small"
                                type="info is-plain"
                                icon="el-icon-sort"
                                class="handle">
                            </el-button>

                            <el-button
                                v-if="item.additional_fields"
                                @click="showEditField(element)"
                                size="small"
                                type="primary"
                                icon="el-icon-edit">
                            </el-button>

                            <el-button
                                @click="removeField(element)"
                                size="small"
                                type="danger"
                                icon="el-icon-delete">
                            </el-button>

                            <el-row :gutter="20">
                                <el-col :sm="24" :span="24" class="padding-tb">
                                    <div style="height: 200px; overflow: hidden;">
                                        {{ getTitle(element) }}
                                    </div>
                                </el-col>
                            </el-row>

                        </div>
                        <div style="clear: left;"></div>
                    </div>
                </template>
            </draggable>

            <div class="padding-trl">
                <div class="block padding-b">
                    <div class="col-12">
                        <el-button
                            type="primary is-plain"
                            size="small"
                            icon="el-icon-plus"
                            @click="showAdd(true)">
                        </el-button>
                    </div>
                </div>
            </div>

            <template v-if="item.additional_fields && showModal">
                <el-drawer
                    v-loading="loading"
                    element-loading-text="Loading..."
                    element-loading-spinner="el-icon-loading"
                    element-loading-background="rgba(0, 0, 0, 0)"
                    v-model="showModal"
                    size="60%"
                    direction="rtl"
                    custom-class="demo-drawer"
                    ref="drawer"
                    :before-close="handleClose">
                    <div class="demo-drawer__content">

                        <el-tabs v-model="defaultLocale" v-if="field_form">
                            <template v-for="(locale,localeKey) in locales">

                                <el-tab-pane class="" :label="locale" :name="locale">
                                    <template v-for="(field,index) in field_form.fields">
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
                                                        <input
                                                            class="form-control"
                                                            :disabled="loading"
                                                            :placeholder="field.placeholder ? field.placeholder : ''"
                                                            v-model="field_form.fields[index].locales[locale]">
                                                    </template>
                                                    <template v-else>
                                                        <input
                                                            class="form-control"
                                                            :disabled="loading"
                                                            :placeholder="field.placeholder ? field.placeholder : ''"
                                                            v-model="field_form.fields[index].value">
                                                    </template>
                                                </template>

                                                <template v-else-if="field.type == 'textarea'">
                                                    <template v-if="field.is_translation">
                                                <textarea class="form-control" :disabled="loading"
                                                          :placeholder="field.placeholder ? field.placeholder : ''"
                                                          v-model="field_form.fields[index].locales[locale]"></textarea>
                                                    </template>
                                                    <template v-else>
                                                <textarea class="form-control" :disabled="loading"
                                                          :placeholder="field.placeholder ? field.placeholder : ''"
                                                          v-model="field_form.fields[index].value"></textarea>
                                                    </template>
                                                </template>

                                                <template v-else-if="field.type == 'wysiwig'">
                                                    <template v-if="field.is_translation">
                                                        <ckeditor
                                                            :editor="editor"
                                                            v-model="field_form.fields[index].locales[locale]">
                                                        </ckeditor>
                                                    </template>
                                                    <template v-else>
                                                        <ckeditor
                                                            :editor="editor"
                                                            v-model="field_form.fields[index].value">
                                                        </ckeditor>
                                                    </template>
                                                </template>

                                                <template v-if="field.type == 'image'">
                                                    <input style="display: block !important;"
                                                           :id="'image_' + index" :ref="'file_' + index" type="file"
                                                           v-on:change="handleFieldFileUpload(index,field)"/>
                                                    <template v-if="field.file">
                                                        <a :href="field.file.full_src" target="_blank">{{ field.file.full_src }}</a>
                                                    </template>
                                                </template>
                                            </div>

                                        </div>
                                    </template>

                                </el-tab-pane>

                            </template>
                        </el-tabs>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="demo-drawer__footer">
                                    <el-button size="medium" type="info is-plain" @click="modal(false)">
                                        {{ lang.close_fields }}
                                    </el-button>
                                    <el-button size="medium" type="primary is-plain" icon="el-icon-check"
                                               @click="saveField"
                                               :disabled="loading" :loading="loading">{{ lang.save_fields }}
                                    </el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-drawer>
            </template>
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
import AddField from "./AddField";
import {getData} from "@/base/mixins/getData";
import {responseParse} from "@/base/mixins/responseParse";

export default {
    components: {AddField, draggable},
    props: [
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
            indexKey: '',
            activeTabName: 'ka',
            dialogVisible: false,
            loading: false,
            form: {
                fields: []
            },
            editor: ClassicEditor,
            showModal: false,
            disabled: false,
            fileList: [],
            edit_data: {},
            additionalFields: this.item.additional_fields,
            field_form: {},
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
        getTitle(element,key = 'title') {
            let title = '';
            let allElements = [];

            if (!(element instanceof Array)) {
                Object.keys(element).map((key) => {
                    allElements.push(element[key]);
                })
            } else {
                allElements = element;
            }

            allElements.every((item) => {
                if (item.value) {
                    title = item.value;
                    return false;
                } else if (item.locales && item.locales[this.defaultLocale]) {
                    title = item.locales[this.defaultLocale];
                    return false;
                }

                return true;
            })

            return title;
        },
        handleRemove(file) {
            this.fileList = this.fileList.filter(function (item) {
                return item.uid != file.uid;
            });
        },
        showAdd() {
            this.indexKey = '';
            let item = Object.assign({}, JSON.parse(JSON.stringify(this.item)));
            this.edit_data.additional_fields = item.additional_fields
            this.createdModal()
            this.forceRerender(true);
        },

        showEditField(element) {
            var index = this.getKeyFromElements(element)
            this.indexKey = index;
            this.edit_data = {};
            this.edit_data.fields = Object.assign({}, JSON.parse(JSON.stringify(this.form.fields[index])));
            this.createdModal()
            this.forceRerender(true);
        },
        createdModal() {
            let editData = Object.assign({}, JSON.parse(JSON.stringify(this.edit_data)));
            let additionalFields = editData.additional_fields;
            let fields = editData.fields;
            this.dialogVisible = true;
            if (typeof this.indexKey === 'number') {
                this.field_form.fields = fields;
            } else {
                this.field_form.fields = additionalFields;
            }
        },
        removeField(element) {
            var index = this.getKeyFromElements(element)
            this.$confirm(this.lang.remove_field_confirm, {
                confirmButtonText: this.lang.remove_field_confirm_yes,
                cancelButtonText: this.lang.remove_field_confirm_no,
                type: 'warning'
            })
                .then(async () => {
                    this.form.fields = this.form.fields.filter((item, i) => {
                        return i != index;
                    });
                });
        },
        async handleFieldFileUpload(index, field) {
            let file = this.$refs['file_' + index].files[0];
            var data = new FormData();
            data.append('file', file);
            data.append('type', 'custom_field_' + field.name);
            await getData({
                method: 'POST',
                url: this.uploadImageRoute,
                data: data
            }).then(response => {
                // Parse response notification.
                responseParse(response);
                if (response.status === 200) {
                    this.field_form.fields[index].file = {...this.field_form.fields[index].file, ...response.data.item}
                }
                this.loading = false
            });
        },

        getKeyFromElements(element) {
            var index = ''
            this.form.fields.forEach((item, key) => {
                if (!index && item.id === element.id) {
                    index = key
                }
            })
            return index
        },
        /**
         *
         * @param data
         */
        updateFieldData(data = undefined, index = '') {
            if (data && index !== '') {
                if (!data.id) {
                    data.id = Date.now()
                }
                this.form.fields[index] = data;
            } else if (data) {
                if (!this.form.fields) {
                    this.form.fields = []
                }
                data.id = Date.now()
                this.form.fields.push(data);
            } else {
                let oldData = this.form;
                this.form = {};
                this.form = oldData;
            }

            this.updateData(this.moduleName, this.fieldKey, this.form);
            this.indexKey = '';
        },

        forceRerender(showComponent = false) {
            // Remove my-component from the DOM
            this.showModal = !showComponent;
            this.$nextTick(() => {
                // Add the component back in
                this.showModal = showComponent;
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
        handleClose() {
            this.indexKey = null
            this.field_form = {}
            this.modal(false);
            // this.updateFieldData(this.field_form.fields, this.indexKey);
        },
        /**
         * Save field data.
         */
        saveField() {
            this.updateFieldData(this.field_form.fields, this.indexKey);
            this.modal(false);
        },
        /**
         * Modal close/show
         */
        modal(status = true) {
            if (status) {
                this.clearInputs();
            } else {
                this.updateFieldData();
            }
            this.showModal = status;
        },
        clearInputs() {
            this.field_form = {}
        },

    }

}

</script>
