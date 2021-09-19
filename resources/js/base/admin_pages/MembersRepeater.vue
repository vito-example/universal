<template>
    <div>
        <draggable
            v-model="form.fields"
            group="elements"
            item-key="id">
            <template #header>
                <el-button
                    @click="addElement"
                    type="primary"
                    size="medium">
                    {{ lang.add_element }}
                </el-button>
            </template>
            <template #item="{element,index}">
                <div class="padding-t col-md-4 col-sm-6 module-images">
                    <div class="block">
                        <el-button
                            @click="showViewPage(element)"
                            size="small"
                            type="info is-plain"
                            icon="el-icon-sort"
                            class="handle">
                        </el-button>

                        <el-button
                            @click="showEditField(index)"
                            size="small"
                            type="primary"
                            icon="el-icon-edit">
                        </el-button>

                        <el-button
                            @click="removeField(index)"
                            size="small"
                            type="danger"
                            icon="el-icon-delete">
                        </el-button>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mt-5" style="overflow: hidden;">
                                    <div v-if="this.moduleName === 'lecturers'">
                                        <a :href="fieldImage(element)" target="_blank" v-if="fieldImage(element)">
                                            <img :src="fieldImage(element)" width="300" height="200">
                                        </a>
                                        <a :href="fieldUrl(element)" target="_blank">
                                            {{ fieldTitle(element) }}
                                        </a>
                                    </div>
                                    <div v-if="this.moduleName === 'sessions'" style="margin-top: 5px">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th>{{ this.lang[element[0].label] }}</th>
                                                <td>{{ element[0].value }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ this.lang[element[1].label] }}</th>
                                                <td>{{ element[1].value }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ this.lang[element[2].label] }}</th>
                                                <td>{{ element[2].value }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ this.lang[element[3].label] }}</th>
                                                <td>{{ element[3].value }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ this.lang[element[4].label] }}</th>
                                                <td v-if="element[4].value === 100">{{ this.lang['status_active'] }}
                                                </td>
                                                <td v-if="element[4].value === 200">{{ this.lang['status_completed'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ this.lang[element[5].label] }}</th>
                                                <td v-if="element[5].value == 100">{{this.lang.type_planed}}</td>
                                                <td v-if="element[5].value == 200">{{this.lang.type_request}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </template>
        </draggable>
        <el-drawer
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0)"
            v-model="dialogVisible"
            size="60%"
            direction="rtl"
            custom-class="demo-drawer"
            ref="drawer"
            :before-close="handleClose">
            <div class="demo-drawer__content">
                <template v-for="(field,index) in dialogForm">
                    <div v-if="field.enable && field.type === 'select_session_type'">
                        <div class="form-group popup">
                            <label class="col-md-2 control-label">{{ this.lang[field.label] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <el-select
                                    reserve-keyword
                                    :loading="loading"
                                    v-model="field.value"
                                    :placeholder="field.placeholder">
                                    <el-option
                                        v-for="(item,key) in field.options"
                                        :key="item.value"
                                        :label="this.lang[item.label] ?? item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group popup" v-if="field.value === 200">
                            <div>
                                <label class="col-md-2 control-label">{{ this.lang['can_register_list'] }}</label>
                                <div class="col-md-10 uppercase-medium">
                                    <el-select
                                        filterable
                                        remote
                                        multiple
                                        reserve-keyword
                                        :loading="selectLoaidng"
                                        :remote-method="query => filterEntity(query,'person_connections',5)"
                                        v-model="field.user_list"
                                        :placeholder="this.lang.can_register_list">
                                        <el-option
                                            v-for="(item,key) in field.user_list_options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group popup" v-if="field.enable && field.type !== 'select_session_type'">
                        <label class="col-md-2 control-label">
                            {{ this.lang[field.label] ?? field.label }}
                            <template v-if="field.is_required">
                                <span class="text-danger">*</span>:
                            </template>
                        </label>
                        <div class="col-md-10">

                            <template v-if="field.type == 'text'">
                                <input
                                    class="form-control"
                                    :disabled="loading"
                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                    v-model="field.value">
                            </template>
                            <template v-if="field.type === 'number'">
                                <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                                    <input
                                        class="form-control"
                                        type="number"
                                        :disabled="loading"
                                        :min="1"
                                        :placeholder="field.placeholder ? lang[field.placeholder] : ''"
                                        v-model="field.value">
                                </div>
                            </template>

                            <template v-else-if="field.type == 'textarea'">
                                <textarea
                                    class="form-control"
                                    :disabled="loading"
                                    :placeholder="field.placeholder ? field.placeholder : ''"
                                    v-model="field.value">
                                </textarea>
                            </template>
                            <template v-else-if="field.type == 'select'">
                                <el-select
                                    filterable
                                    remote
                                    reserve-keyword
                                    :loading="loading"
                                    :remote-method="query => filterEntity(query, field, index)"
                                    @change="changeSelect(field,index)"
                                    v-model="field.value"
                                    :placeholder="field.placeholder">
                                    <el-option
                                        v-for="(item,key) in field.options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else-if="field.type == 'select_session'">
                                <el-select
                                    reserve-keyword
                                    :loading="loading"
                                    v-model="field.value"
                                    :placeholder="field.placeholder">
                                    <el-option
                                        v-for="(item,key) in field.options"
                                        :key="item.value"
                                        :label="this.lang[item.label] ?? item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                            </template>

                            <template v-else-if="field.type == 'wysiwyg'">
                                <ckeditor :editor="editor"
                                          v-model="field.value"></ckeditor>
                            </template>
                            <template v-else-if="field.type == 'image'">
                                <input style="display: block !important;"
                                       :id="'image_' + index" :ref="'file_' + index" type="file"
                                       v-on:change="handleFieldFileUpload(index,field)"/>
                                <template v-if="field.file">
                                    <img :src="field.file.full_src"
                                         style="width: 100%;">
                                </template>
                            </template>
                            <template v-else-if="field.type == 'file'">
                                <input style="display: block !important;"
                                       :id="'image_' + index" :ref="'file_' + index" type="file"
                                       v-on:change="handleFieldFileUpload(index,field)"/>
                                <template v-if="field.file">
                                    <a :href="field.file.full_src" target="_blank">{{ field.file.full_src }}</a>
                                </template>
                            </template>
                            <template v-else-if="field.type === 'datetime'">
                                <el-date-picker
                                    v-model="field.value"
                                    type="datetime"
                                    format="YYYY-MM-DD HH:mm:ss"
                                    @change="changeDateTime(field,index)"
                                    :placeholder="field.placeholder ? lang[field.placeholder] : ''">
                                </el-date-picker>
                            </template>
                        </div>
                    </div>
                </template>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="demo-drawer__footer">
                            <el-button size="medium" type="info is-plain" @click="modal(false)">{{ lang.close_fields }}
                            </el-button>
                            <el-button size="medium" type="primary is-plain" icon="el-icon-check" @click="saveField"
                                       :disabled="loading" :loading="loading">{{ lang.save_fields }}
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </el-drawer>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import {getData} from "@/base/mixins/getData";
import {responseParse} from "@/base/mixins/responseParse";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import MyUploadAdapter from "@/base/mixins/EditorCustomUpload";
import {notifications} from "../mixins/notifications";

export default {
    components: {
        draggable,
    },
    props: [
        'lang',
        'elementsField',
        'item',
        'moduleName',
        'updateData',
        'options',
        'routes',
        'editorConfig',
        'allFields'
    ],
    data() {
        return {
            form: {
                fields: []
            },
            dialogForm: [],
            dialogVisible: false,
            loading: false,
            editor: ClassicEditor,
            editorConfigData: {},
            selectLoading: false,
        }
    },
    created() {
        if (this.item) {
            this.form = this.item
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
                this.form = this.item
            }
        },
    },
    methods: {
        async filterEntity(query, field, index) {
            if (query.length < 2) {
                return ''
            }
            this.loading = true
            const name = field.name ?? field
            await getData({
                method: 'GET',
                url: this.routes.filters[name],
                data: {
                    q: query,
                    full_name: query,
                }
            }).then(response => {
                responseParse(response, false);
                if (response.status === 200) {
                    let options = response.data.data.items;

                    if (this.form.fields !== undefined) {
                        options = options.filter((el) => {
                            let index = this.form.fields.find((e) => e[1].value === el.value)
                            if (index === undefined) {
                                return true;
                            }
                            return false;
                        })
                    }
                    if (name === 'person_connections') {
                        let data = [...this.dialogForm[index].user_list_options, ...response.data.data.items];
                        this.dialogForm[index].user_list_options = Array.from(new Set(data.map(JSON.stringify))).map(JSON.parse);
                    } else {
                        this.dialogForm[index].options = options
                    }
                }
                this.loading = false
            });
        },
        changeSelect(field) {
            if (field.name === 'entity_type') {
                this.showHideEntityTypes(field.value)
            } else {
                field.options = field.options.filter(function (item) {
                    return item.value === field.value;
                })
            }
        },
        changeDateTime(field, index) {
            this.dialogForm[index].value =moment(field.value).format('YYYY-MM-DD HH:mm:ss')
            console.log(this.dialogForm);
        },
        showHideEntityTypes(entityType = 'users') {
            Object.keys(this.dialogForm).forEach((key) => {
                var item = this.dialogForm[key]
                if (item.name === 'users' || item.name === 'companies') {
                    if (entityType === 'users') {
                        if (item.name === 'users') {
                            item.enable = true
                        } else {
                            item.enable = false
                        }
                    }
                    if (entityType === 'companies') {
                        if (item.name === 'companies') {
                            item.enable = true
                        } else {
                            item.enable = false
                        }
                    }
                }
                this.dialogForm[key] = item
            });
        },
        meyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        },
        showEditField(index) {
            this.indexKey = index;
            this.dialogForm = [];
            this.dialogForm = this.form.fields[index];
            this.showHideEntityTypes()
            this.forceRerender(true);
        },
        showViewPage(element) {
            if (this.moduleName === 'sessions') {
                if (element[3].session_id) {
                    window.open(`${window.location.origin}/admin/v1/event_session/show/${element[3].session_id}`, '_blank')
                }
            }
        },
        addElement() {
            this.indexKey = null
            this.dialogForm = [];
            this.dialogForm = Object.assign({}, JSON.parse(JSON.stringify(this.allFields)))
            this.showHideEntityTypes()
            this.dialogVisible = true
        },
        forceRerender(showComponent = false) {
            this.dialogVisible = !showComponent;
            this.$nextTick(() => {
                this.dialogVisible = showComponent;
            });
        },
        removeField(index) {
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
        clearInputs() {
            this.indexKey = null
            this.dialogForm = []
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

            this.dialogVisible = status;
        },
        updateFieldData(data = undefined, index = '') {
            if (data && index !== '') {
                this.form.fields[index] = data;
            } else if (data) {
                this.form.fields.push(data);
            } else {
                let oldData = this.form;
                this.form = {};
                this.form = oldData;
            }

            this.updateData(this.moduleName, this.form);
        },
        handleClose(done) {
            this.updateFieldData();
            this.modal(false);
        },

        /**
         * Save field data.
         */
        saveField() {
            if (this.moduleName === 'sessions' && this.validateSession() === false) {
                return;
            }
            if (this.moduleName === 'lecturers' && this.validateLecturer() === false) {
                return;
            }
            if (this.indexKey !== null) {
                this.form.fields[this.indexKey] = this.dialogForm
            } else {
                if (!this.form.fields) {
                    this.form.fields = [];
                }
                this.form.fields.push(this.dialogForm)
            }
            this.modal(false);
            this.clearInputs()
        },
        validateSession() {
            switch (true) {
                case (this.dialogForm[1].value === undefined):
                    notifications({
                        status: 'error',
                        message: this.lang.please_input_start_date
                    });
                    return false;
                case (this.dialogForm[2].value === undefined):
                    notifications({
                        status: 'error',
                        message: this.lang.please_input_end_date
                    });
                    return false;
                case (this.dialogForm[2].value <= this.dialogForm[1].value):
                    notifications({
                        status: 'error',
                        message: this.lang.start_date_more_than_end_date
                    });
                    return false;
                default:
                    return true;
            }
        },
        validateLecturer() {
            switch (true) {
                case (!this.dialogForm[1].value):
                    notifications({
                        status: 'error',
                        message: this.lang.please_select_lecturer
                    });
                    return false;
                default:
                    return true;
            }
        },
        fieldTitle(fields) {
            var title = ''
            var entityType = this.getEntityType(fields);
            Object.keys(fields).forEach((key) => {
                if (!title && fields[key].name == entityType) {
                    title = fields[key].options[0].label
                }
            })
            return title
        },
        fieldImage(fields) {
            var imageUrl = ''
            var entityType = this.getEntityType(fields);
            Object.keys(fields).forEach((key) => {
                if (!imageUrl && fields[key].name == entityType) {
                    imageUrl = fields[key].options[0].image_url
                }
            })
            return imageUrl
        },
        fieldUrl(fields) {
            var id = ''
            var entityType = this.getEntityType(fields);
            Object.keys(fields).forEach((key) => {
                if (!id && fields[key].name == entityType) {
                    id = fields[key].value
                }
            })
            return this.routes.entities[entityType] + '/' + id
        },
        getEntityType(fields) {
            var entityType = ''
            Object.keys(fields).forEach((key) => {
                if (fields[key].name == 'entity_type') {
                    entityType = fields[key].value
                }
            })
            return entityType
        },
        async handleFieldFileUpload(index, field) {
            let file = this.$refs['file_' + index].files[0];
            var data = new FormData();
            data.append('file', file);
            data.append('type', 'custom_field_' + field.name);
            await getData({
                method: 'POST',
                url: this.routes.upload_image,
                data: data
            }).then(response => {
                // Parse response notification.
                responseParse(response);
                if (response.status == 200) {
                    this.dialogForm[index].file = {...this.dialogForm[index].file, ...response.data.item}
                }
                this.loading = false
            });
        },
    }
}
</script>
