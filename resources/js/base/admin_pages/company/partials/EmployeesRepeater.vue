<template>
    <div>
        <draggable
            v-model="form.employees"
            group="elements"
            item-key="id">
            <template #header>
                <div class="row">
                    <div class="col">
                        <el-button
                            class="padding"
                            @click="addElement"
                            type="primary"
                            size="medium">
                            {{ lang.add_element }}
                        </el-button>
                    </div>
                </div>
            </template>
            <template #item="{element,index}">
                <div class="padding-t col-md-4 col-sm-6 module-images">
                    <div class="block">
                        <el-button
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
                                    <div style="margin-top: 5px">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th>{{this.lang.full_name}}</th>
                                                <td>{{element.name}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{this.lang.email}}</th>
                                                <td>{{element.email}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{this.lang.phone}}</th>
                                                <td>{{element.phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{this.lang.role}}</th>
                                                <td>{{element.role}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{this.lang.specialty}}</th>
                                                <td>{{element.specialty}}</td>
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
                <div class="form-group popup">
                    <label class="col-md-2 control-label">
                        {{ this.lang.full_name }}
                        <span class="text-danger">*</span>:
                    </label>
                    <div class="col-md-10">
                        <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                            <input
                                class="form-control"
                                :disabled="loading"
                                :placeholder="this.lang.enter_full_name"
                                v-model="dialogForm.name">
                        </div>
                    </div>
                </div>
                <div class="form-group popup">
                    <label class="col-md-2 control-label">
                        {{ this.lang.email }}
                        <span class="text-danger">*</span>:
                    </label>
                    <div class="col-md-10">
                        <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                            <input
                                type="email"
                                class="form-control"
                                :disabled="loading"
                                :placeholder="this.lang.enter_email"
                                v-model="dialogForm.email">
                        </div>
                    </div>
                </div>
                <div class="form-group popup">
                    <label class="col-md-2 control-label">
                        {{ this.lang.phone }}
                    </label>
                    <div class="col-md-10">
                        <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                            <input
                                class="form-control"
                                :disabled="loading"
                                :placeholder="this.lang.enter_phone"
                                v-model="dialogForm.phone">
                        </div>
                    </div>
                </div>
                <div class="form-group popup">
                    <label class="col-md-2 control-label">
                        {{ this.lang.role }}
                    </label>
                    <div class="col-md-10">
                        <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                            <input
                                class="form-control"
                                :disabled="loading"
                                :placeholder="this.lang.enter_role"
                                v-model="dialogForm.role">
                        </div>
                    </div>
                </div>
                <div class="form-group popup">
                    <label class="col-md-2 control-label">
                        {{ this.lang.specialty }}
                    </label>
                    <div class="col-md-10">
                        <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                            <input
                                class="form-control"
                                :disabled="loading"
                                :placeholder="this.lang.enter_specialty"
                                v-model="dialogForm.specialty">
                        </div>
                    </div>
                </div>
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
import Label from "../../../../Jetstream/Label";
import {notifications} from "../../../mixins/notifications";

export default {
    components: {
        Label,
        draggable,
    },
    props: [
        'items',
        'updateData',
        'routes',
        'lang'
    ],
    data() {
        return {
            form: {
                employees: []
            },
            dialogForm: {
                id: null,
                name: '',
                email: '',
                phone: '',
                role: '',
                specialty: ''
            },
            dialogVisible: false,
            loading: false,
        }
    },
    created() {
        if (this.items) {
            this.form.employees = this.items
        }
    },
    watch: {
        'items'() {
            if (this.items && this.items.length) {
                this.form.employees = this.items
            }
        }
    },
    methods: {
        showEditField(index) {
            this.indexKey = index;
            this.dialogForm = [];
            this.dialogForm = this.form.employees[index];
            this.forceRerender(true);
        },
        addElement() {
            this.indexKey = null
            this.dialogForm = [];
            this.dialogForm = Object.assign({}, JSON.parse(JSON.stringify(this.dialogForm)))
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
                    this.form.employees = this.form.employees.filter((item, i) => {
                        return i !== index;
                    });
                    this.updateData('employees', this.form.employees)
                });
        },
        validateEmail(email) {
            let validate = /\S+@\S+\.\S+/;
            return validate.test(email);
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
            let oldData = this.form;
            this.form = {};
            this.form = oldData;
            this.updateData('employees', this.form.employees);
        },
        handleClose(done) {
            this.modal(false);
        },

        /**
         * Save field data.
         */
        saveField() {
            if (false === this.validateEmployee()) {
                return;
            }
            if (this.indexKey !== null) {
                this.form.employees[this.indexKey] = this.dialogForm
            } else {
                if (!this.form.employees) {
                    this.form.employees = [];
                }
                this.form.employees.push(this.dialogForm)
            }
            this.modal(false);
            this.clearInputs()
        },
        validateEmployee() {
            switch (true) {
                case (this.dialogForm.name === undefined || this.dialogForm.name === ''):
                    notifications({
                        status: 'error',
                        message: this.lang.please_input_full_name
                    });
                    return false;
                case (this.dialogForm.email === undefined || this.dialogForm.email === ''):
                    notifications({
                        status: 'error',
                        message: this.lang.please_input_email
                    });
                    return false;
                case (!this.validateEmail(this.dialogForm.email)):
                    notifications({
                        status: 'error',
                        message: this.lang.please_input_valid_email
                    });
                    return false;
                default:
                    return true;
            }
        },
    }
}
</script>
