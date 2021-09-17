<template>
    <div>
        <div class="block">
            <el-form v-loading="loading"
                     element-loading-text="Loading..."
                     element-loading-spinner="el-icon-loading"
                     element-loading-background="rgba(0, 0, 0, 0.0)"
                     ref="form" :model="form" class="form-horizontal form-bordered">

                <div class="row">
                    <div class="form-group dashed" v-if="!this.id">
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.training }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-select
                                filterable
                                remote
                                reserve-keyword
                                :loading="selectLoaidng"
                                :remote-method="query => filterEntity(query,'event','event_options')"
                                v-model="form.event_id"
                                :placeholder="lang.training">
                                <el-option
                                    v-for="(item,key) in options.event_options"
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
                            class="text-danger">*</span>{{ lang.max_person }}:</label>
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
                            class="text-danger">*</span>{{ lang.start_date }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-date-picker
                                v-model="form.start_date"
                                type="datetime"
                                format="YYYY-MM-DD HH:mm:ss"
                                :placeholder="lang.start_date">
                            </el-date-picker>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.end_date }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-date-picker
                                v-model="form.end_date"
                                type="datetime"
                                format="YYYY-MM-DD HH:mm:ss"
                                :placeholder="lang.end_date">
                            </el-date-picker>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.timezone }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-select v-model="form.timezone" filterable :placeholder="lang.timezone">
                                <el-option
                                    v-for="(item,key) in options.timezones"
                                    :key="item"
                                    :label="item"
                                    :value="item">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.status }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-select v-model="form.status" filterable :placeholder="lang.status">
                                <el-option
                                    v-for="(item,key) in options.statuses"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.type }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-select v-model="form.type" filterable :placeholder="lang.type">
                                <el-option
                                    v-for="(item,key) in options.types"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="form-group dashed" v-if="form.type === 200">
                        <div>
                            <label class="col-md-2 control-label">{{ lang['can_register_list'] }}</label>
                            <div class="col-md-10 uppercase-medium">
                                <el-select
                                    filterable
                                    remote
                                    multiple
                                    reserve-keyword
                                    :loading="selectLoaidng"
                                    :remote-method="query => filterEntity(query,'person_connections','user_list_options')"
                                    v-model="form.user_list"
                                    :placeholder="lang.can_register_list">
                                    <el-option
                                        v-for="(item,key) in options.user_list_options"
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

                        <label class="col-md-2 control-label">{{ lang.price }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                                <input class="form-control" type="number"
                                       :disabled="loading"
                                       v-model="form.price">
                            </div>
                        </div>
                    </div>
                    <div class="form-group dashed">

                        <label class="col-md-2 control-label">{{ lang.link }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <div class="el-input el-input--prefix el-input--suffix el-date-editor ">
                                <input class="form-control" type="number"
                                       :disabled="loading"
                                       v-model="form.link">
                            </div>
                        </div>
                    </div>
                </div>
            </el-form>
        </div>
    </div>
</template>


<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import MyUploadAdapter from "../../../mixins/EditorCustomUpload";
import {responseParse} from "@/base/mixins/responseParse";
import {getData} from "@/base/mixins/getData";

export default {
    props: [
        'lang',
        'locales',
        'defaultLocale',
        'routes',
        'updateData',
        'item',
        'options',
        'editorConfig',
        'id'
    ],
    data() {
        return {
            form: {
                type: 100,
                status: 100,
                timezone: 'Asia/Tbilisi',
                max_person: 1
            },
            activeTabName: '',
            loading: false,
            selectLoading: false,
            editor: ClassicEditor,
            editorConfigData: {},
            optionsData: {},
            branches: [],
            selectLoaidng: false
        }
    },
    updated() {
        this.updateData('main', this.form);
    },
    watch: {
        'item'() {
            if (this.item) {
                this.form = this.item;
                this.optionsData = this.options
            }
        },
        'form.start_date' (value) {
            this.form.start_date = moment(value).format('YYYY-MM-DD HH:mm:ss')
        },
        'form.end_date' (value) {
            this.form.end_date = moment(value).format('YYYY-MM-DD HH:mm:ss')
        },
    },
    methods: {
        async filterEntity(query, module, optionModule) {
            if (query.length < 2) {
                return ''
            }
            this.selectLoading = true
            await getData({
                method: 'GET',
                url: this.routes.filters[module],
                data: {
                    q: query
                }
            }).then(response => {
                responseParse(response, false);
                if (response.status === 200) {
                    let data = [...this.options[optionModule], ...response.data.data.items];
                    this.options[optionModule] = Array.from(new Set(data.map(JSON.stringify))).map(JSON.parse);
                }
                this.selectLoading = false
            });
        }
    }
}

</script>
