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
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.title }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.title">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.identify_id }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.identify_id">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.address }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.address">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.description }}:</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.description">
                        </div>
                    </div>

                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.company_owners }}</label>
                        <div class="col-md-10 uppercase-medium">
                            <el-select
                                filterable
                                remote
                                multiple
                                reserve-keyword
                                :loading="selectLoading"
                                :remote-method="query => filterEntity(query,'users')"
                                v-model="form.owners"
                                :placeholder="lang.company_owners">
                                <el-option
                                    v-for="(item,key) in optionsData.users"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ lang.profile_image }}</label>
                        <div class="col-md-6">
                            <input style="display: block !important;" id="profile" ref="file" type="file"
                                   v-on:change="handleFileUpload('profile')"/>
                        </div>
                        <div v-if="form.images && form.images.profile">
                            <div class="col-md-offset-2 col-md-4 padding-t">
                                <img :src="form.images.profile.item.full_src" style="width: 100%;">
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
        'editorConfig'
    ],
    data() {
        return {
            form: {},
            activeTabName: '',
            loading: false,
            selectLoading: false,
            editor: ClassicEditor,
            editorConfigData: {},
            optionsData: {},
            branches: []
        }
    },
    updated() {
        this.updateData('main', this.form);
    },
    watch: {
        'editorConfig'() {
            if (this.editorConfig) {
                this.editorConfigData = this.editorConfig;
                this.editorConfigData.extraPlugins = [this.meyCustomUploadAdapterPlugin];
            }
        },
        'defaultLocale'() {
            this.activeTabName = this.defaultLocale;
        },
        'locales'() {
            if (!this.item || Object.keys(this.item).length == 0) {
                this.locales.forEach((value, index) => {
                    if (!this.form[value]) {
                        this.form[value] = {};
                    }
                });
            }
        },
        'item'() {
            if (this.item) {
                this.form = this.item;
                this.optionsData = this.options
            }
        }
    },
    methods: {
        async filterEntity(query,module) {
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
                    this.optionsData[module] = response.data.data.items
                }
                this.selectLoading = false
            });
        },
        meyCustomUploadAdapterPlugin(editor) {

            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };

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
                if (response.status === 200) {
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
