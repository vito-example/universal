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
                        <label class="col-md-2 control-label"><span class="text-danger">*</span>{{ lang.name }}</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.name">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span class="text-danger">*</span>{{ lang.surname }}</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.surname">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span class="text-danger">*</span>{{ lang.phone_number }}</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.phone_number">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span class="text-danger">*</span>{{ lang.email }}</label>
                        <div class="col-md-10 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.email">
                        </div>
                    </div>

                    <div class="form-group dashed">
                        <label class="col-md-2 control-label">{{ lang.password }}</label>
                        <div class="col-md-10 uppercase-medium">
                            <input type="password" class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.password">
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
            editor: ClassicEditor,
            editorConfigData: {}
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
        'item'() {
            if (this.item) {
                this.form = this.item;
            }
        }
    },
    methods: {
        meyCustomUploadAdapterPlugin(editor) {

            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };

        },
    }
}

</script>
