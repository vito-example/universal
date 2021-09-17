<template>
    <div>
        <div class="col hide-tab">
            <div class="registration-btn project-title-buttons">

                <div class="project-title">

                </div>

                <el-tabs v-model="tabValue"
                         tab-position="left" style="height: auto"
                         v-loading="loading"
                         element-loading-text="Loading..."
                         element-loading-spinner="el-icon-loading"
                         element-loading-background="rgba(0, 0, 0, 0.0)">

                    <el-tab-pane :label="lang.main_tab" key="main" name="main">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.main_tab" placement="top-start">
                                <i class="el-icon-folder-opened"></i>
                            </el-tooltip>
                        </span>

                        <div>
                            <div class="block">
                                <el-form v-loading="loading"
                                         element-loading-text="Loading..."
                                         element-loading-spinner="el-icon-loading"
                                         element-loading-background="rgba(0, 0, 0, 0.0)"
                                         ref="form" :model="form" class="form-horizontal form-bordered">

                                    <div class="row">
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label"><span
                                                class="text-danger">*</span>{{ trans.training }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-select
                                                    disabled
                                                    reserve-keyword
                                                    v-model="form.event_id"
                                                    :placeholder="trans.training">
                                                    <el-option
                                                        v-for="(item,key) in options.training"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label"><span
                                                class="text-danger">*</span>{{ trans.max_person }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                                                    <input class="form-control" maxlength="150"
                                                           :disabled="loading"
                                                           v-model="form.max_person">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label"><span
                                                class="text-danger">*</span>{{ trans.start_date }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-date-picker
                                                    v-model="form.start_date"
                                                    type="datetime"
                                                    format="YYYY-MM-DD HH:mm:ss"
                                                    value-format="YYYY/MM/DD HH:mm:ss"
                                                    :placeholder="trans.start_date">
                                                </el-date-picker>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label"><span
                                                class="text-danger">*</span>{{ trans.end_date }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-date-picker
                                                    v-model="form.end_date"
                                                    type="datetime"
                                                    format="YYYY-MM-DD HH:mm:ss"
                                                    value-format="YYYY/MM/DD HH:mm:ss"
                                                    :placeholder="trans.end_date">
                                                </el-date-picker>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label"><span
                                                class="text-danger">*</span>{{ trans.timezone }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-select v-model="form.timezone" filterable
                                                           :placeholder="trans.timezone">
                                                    <el-option
                                                        v-for="(item,key) in options.timezone"
                                                        :key="item"
                                                        :label="item"
                                                        :value="item">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label">{{ trans.status }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-select v-model="form.status" :placeholder="trans.status">
                                                    <el-option
                                                        v-for="(item,key) in options.status"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label">{{ trans.type }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-select v-model="form.type" disabled :placeholder="trans.type">
                                                    <el-option
                                                        v-for="(item,key) in options.type"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group dashed" v-if="form.type === 200">
                                            <div>
                                                <label class="col-md-2 control-label">{{ trans.can_register_list }}</label>
                                                <div class="col-md-10 uppercase-medium">
                                                    <el-select
                                                        disabled
                                                        v-model="form.user"
                                                        :placeholder="trans.can_register_list">
                                                        <el-option
                                                            v-for="(item,key) in options.users"
                                                            :key="item.value"
                                                            :label="item.label"
                                                            :value="item.value"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">

                                            <label class="col-md-2 control-label">{{ trans.price }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                                                    <input class="form-control" type="number"
                                                           :disabled="loading"
                                                           v-model="form.price">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group dashed">

                                            <label class="col-md-2 control-label">{{ trans.link }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                                                    <input class="form-control" type="text"
                                                           :disabled="loading"
                                                           v-model="form.link">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </el-form>
                            </div>
                        </div>

                    </el-tab-pane>
                </el-tabs>


            </div>
            <div class="project-buttons">
                <el-button type="primary"
                           size="medium"
                           icon="el-icon-check"
                           @click="save"
                           :disabled="loading"
                           style="margin: 15px 0 30px 0px">{{ trans.save_text }}
                </el-button>
            </div>
        </div>
    </div>
</template>

<script>

import {responseParse} from '../../mixins/responseParse'
import {getData} from '../../mixins/getData'

export default {
    props: [
        'lang',
        'saveRoute',
        'eventSessionAttempt',
        'options',
    ],
    data() {
        return {
            form: {
                max_person:  1,
                event_id: this.eventSessionAttempt.event_id,
                type: 200,
                user: this.eventSessionAttempt.user_id,
                timezone: 'Asia/Tbilisi',
                status: 100
            },
            trans: JSON.parse(this.lang),
            options: JSON.parse(this.options),
            tabValue: 'main',

        }
    },
    watch: {
        'form.start_date' (value) {
            this.form.start_date = moment(value).format('YYYY-MM-DD HH:mm:ss')
        },
        'form.end_date' (value) {
            this.form.end_date = moment(value).format('YYYY-MM-DD HH:mm:ss')
        },
    },
    methods: {
        async save() {
            this.loading = true;
            await getData({
                method: 'POST',
                url: this.saveRoute,
                data: this.form
            }).then(response => {
                // Parse response notification.
                responseParse(response);
                if (response.status === 200) {
                    // Response data.
                    let data = response.data.data;
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
                this.loading = false
            })
        },
        /**
         *
         * @param module
         * @param data
         */
        updateData(module, data) {
            this.form[module] = data;
        },
    }
}

</script>
