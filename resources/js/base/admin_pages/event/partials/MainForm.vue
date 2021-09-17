<template>
    <div>
        <div class="block">
            <el-form v-loading="loading"
                     element-loading-text="Loading..."
                     element-loading-spinner="el-icon-loading"
                     element-loading-background="rgba(0, 0, 0, 0.0)"
                     ref="form" :model="form" class="form-horizontal form-bordered">

                <el-tabs v-model="activeTabName">
                    <template v-for="locale in locales">
                        <el-tab-pane class="" :label="locale" :name="locale">

                            <div class="row">
                                <div class="form-group dashed">
                                    <label class="col-md-2 control-label"><span class="text-danger">*</span>{{ lang.title }} <span class="grey">{{ locale }}</span>:</label>
                                    <div class="col-md-10 uppercase-medium">
                                        <input class="form-control" maxlength="150"
                                               :disabled="loading"
                                               v-model="form[locale].title">
                                    </div>
                                </div>

                                <div class="form-group editor-large">
                                    <label class="col-md-1 control-label"><span class="text-danger">*</span>{{ lang.description }} <span>{{ locale }}</span>:</label>
                                    <div class="col-md-10">
                                        <ckeditor :editor="editor"
                                                  :config="editorConfigData"
                                                  v-model="form[locale].description">

                                        </ckeditor>
                                    </div>
                                </div>

                                <div class="form-group editor-large">
                                    <label class="col-md-1 control-label"><span class="text-danger"></span>{{ lang.syllabus }} <span>{{ locale }}</span>:</label>
                                    <div class="col-md-10">
                                        <ckeditor :editor="editor"
                                                  :config="editorConfigData"
                                                  v-model="form[locale].syllabus">

                                        </ckeditor>
                                    </div>
                                </div>

                                <div class="form-group dashed">
                                    <label class="col-md-2 control-label">{{ lang.place }} <span class="grey">{{ locale }}</span>:</label>
                                    <div class="col-md-10 uppercase-medium">
                                        <input class="form-control" maxlength="150"
                                               :disabled="loading"
                                               v-model="form[locale].place">
                                    </div>
                                </div>

                                <template v-if="locale == defaultLocale">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">{{ lang.training_directions }}</label>
                                        <div class="col-md-4 uppercase-medium">
                                            <treeselect
                                                v-model="form.directions"
                                                :multiple="true"
                                                :options="directions"
                                                :value-consists-of="valueConsistsOf"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group dashed">
                                        <label class="col-md-2 control-label">{{ lang.duration }}</label>
                                        <div class="col-md-4 uppercase-medium">
                                            <input type="number" class="form-control" min="1"
                                                   :disabled="loading"
                                                   v-model="form.duration">
                                        </div>
                                    </div>
                                    <div class="form-group dashed">
                                        <label class="col-md-2 control-label">{{ lang.phone }}</label>
                                        <div class="col-md-4 uppercase-medium">
                                            <input type="text" class="form-control"
                                                   :disabled="loading"
                                                   v-model="form.phone">
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

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">{{ lang.files }}</label>
                                        <div class="col-md-10">
                                            <members-repeater
                                                :editorConfig="editorConfig"
                                                :item="files"
                                                :routes="routes"
                                                :options="options"
                                                :update-data="updateDataElementData"
                                                :all-fields="options.files_attributes"
                                                :module-name="'files'"
                                                :lang="lang">
                                            </members-repeater>
                                        </div>
                                    </div>

                                </template>
                            </div>
                        </el-tab-pane>
                    </template>
                </el-tabs>
            </el-form>
        </div>
    </div>
</template>


<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import MyUploadAdapter from "../../../mixins/EditorCustomUpload";
import {responseParse} from "@/base/mixins/responseParse";
import {getData} from "@/base/mixins/getData";
import MembersRepeater from "@/base/admin_pages/event/partials/MembersRepeater";
// import the component
import Treeselect from 'vue3-treeselect'
// import the styles
import 'vue3-treeselect/dist/vue3-treeselect.css'

    export default {
        components: {MembersRepeater,Treeselect},
        props: [
            'lang',
            'locales',
            'defaultLocale',
            'routes',
            'updateData',
            'item',
            'options',
            'editorConfig',
            'directions'
        ],
        data(){
            return {
                form: {
                },
                activeTabName: '',
                loading: false,
                editor: ClassicEditor,
                editorConfigData: {},
                files: [],
                valueConsistsOf: 'ALL',
            }
        },
        updated() {
            this.updateData('main', this.form);
            this.valueConsistsOf = 'BRANCH_PRIORITY';
        },
        created() {
            if(this.editorConfig) {
                this.editorConfigData = this.editorConfig;
                this.editorConfigData.extraPlugins = [this.meyCustomUploadAdapterPlugin];
            }
        },
        watch: {
            'files'(){
                this.form.files = this.files
            },
            'editorConfig'(){
                if(this.editorConfig) {
                    this.editorConfigData = this.editorConfig;
                    this.editorConfigData.extraPlugins = [this.meyCustomUploadAdapterPlugin];
                }
            },
            'defaultLocale'(){
                this.activeTabName = this.defaultLocale;
            },
            'locales'(){
                if (!this.item || Object.keys(this.item).length == 0) {
                    this.locales.forEach((value,index) => {
                        if(!this.form[value]) {
                            this.form[value] = {};
                        }
                    });
                }
            },
            'item'(){
                if (this.item) {
                    this.form = this.item;
                    this.files = this.item.files_meta
                }
            }
        },
        methods: {
            updateDataElementData (moduleName, form) {
                this.form[moduleName] = form
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
