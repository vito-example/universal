<template>
    <div>
        <div class="block">
            <el-form v-loading="loading"
                     element-loading-text="Loading..."
                     element-loading-spinner="el-icon-loading"
                     element-loading-background="rgba(0, 0, 0, 0.0)"
                     ref="form" :model="form" class="form-horizontal form-bordered">
                <div class="row">
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.training_form }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <el-select v-model="form.form" filterable  :placeholder="lang.form">
                                <el-option
                                    v-for="(item,key) in options.forms"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.training_type }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <el-select v-model="form.type" filterable  :placeholder="lang.type">
                                <el-option
                                    v-for="(item,key) in options.types"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.event_iframe }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <textarea class="form-control"
                                      rows="5"
                                      cols="5"
                                   :disabled="loading"
                                      v-model="form.event_meta.iframe"></textarea>
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.price_options }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <el-select v-model="form.event_meta.price_option_value" filterable  :placeholder="lang.price_options">
                                <el-option
                                    v-for="(item,key) in options.price_options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>

                    <template v-if="isPaidForAll">
                        <div class="form-group dashed">
                            <label class="col-md-2 control-label">{{ lang.currencies }}:</label>
                            <div class="col-md-4 uppercase-medium">
                                <el-select v-model="form.event_meta.currency" filterable  :placeholder="lang.currencies">
                                    <el-option
                                        v-for="(item,key) in options.currencies"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </template>

                    <template v-if="isPaidForAll">
                        <div class="form-group dashed">
                            <label class="col-md-2 control-label">{{ lang.price }}</label>
                            <div class="col-md-4 uppercase-medium">
                                <input type="number" class="form-control" min="1" maxlength="150"
                                       :disabled="loading"
                                       v-model="form.event_meta.price">
                            </div>
                        </div>
                    </template>

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
import moment from 'moment';

export default {
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
            form: {},
            activeTabName: '',
            loading: false,
            editor: ClassicEditor,
            editorConfigData: {},
            price_activities: [],
        }
    },

    updated() {
        this.updateData('options', this.form);
    },
    created () {
        if(!this.item) {
            this.form = {
                type: 100,
                form: 100,
                event_meta: {
                    price_option_value: 'paid_for_all',
                    currency: 'gel',
                    price_person_total: 1,
                    price: 1
                }
            }
        }
    },
    computed: {
        isPaidForAll() {
            return this.form && this.form.event_meta && this.form.event_meta.price_option_value === 'paid_for_all'
        }
    },
    watch: {
        'form.type' () {
            this.$emit("changeTrainingType",this.form.type)
        },
        'form.event_meta.price_option_value' () {
            if(!this.isPaidForAll && this.form.event_meta) {
                this.form.event_meta.price = null
                this.form.event_meta.price_person_total = 1
                this.form.event_meta.currency = null
            }
        },
        'form.start_date' (value) {
            this.form.start_date = moment(value).format('YYYY-MM-DD HH:mm:ss')
        },
        'editorConfig'() {
            if (this.editorConfig) {
                this.editorConfigData = this.editorConfig;
                this.editorConfigData.extraPlugins = [this.meyCustomUploadAdapterPlugin];
            }
        },
        'item'() {
            if (this.item) {
                this.form = this.item;
                if (this.paidForSomActivities) {
                    this.price_activities = this.form.event_meta.price_activities
                }
            } else {
                this.form = {
                    event_meta: {}
                }
            }
        }
    },
    methods: {
        updateMultipleInput () {
            this.setMultipleFields()
        },
        setMultipleFields () {
            this.form.event_meta.price_activities = this.price_activities
        },
        meyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };
        },
        removeAttributeOption(idx,module) {
            if (module === 'price_activities') {
                this.price_activities.splice(idx, 1);
            }
        },
        /**
         * Add attribute option.
         */
        addAttributeOption(module) {
            if (module === 'price_activities') {
                this.price_activities.push({ price: '', activity_id: ''});
            }
        },
        async handleFileUpload(inputId) {
            let file = this.$refs.file.files[0]
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
                    var itemObject = {};
                    itemObject[inputId] = {item: response.data.item};
                    this.form.images = {...this.form.images, ...itemObject}
                    this.form = {...this.form};
                }
                this.loading = false
            });

        },
    }
}

</script>
