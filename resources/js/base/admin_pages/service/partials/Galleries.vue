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
                        <label class="col-md-1 control-label">{{ lang.galleries }}</label>
                        <div class="col-md-11">
                            <members-repeater
                                :editorConfig="editorConfig"
                                :item="galleries"
                                :routes="routes"
                                :options="options"
                                :update-data="updateDataElementData"
                                :all-fields="options.galleries_attributes ? options.galleries_attributes : []"
                                :module-name="'galleries'"
                                :lang="lang">
                            </members-repeater>
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
import draggable from "vuedraggable";
import MembersRepeater from "@/base/admin_pages/MembersRepeater";

export default {
    components: {MembersRepeater},
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
            galleries: []
        }
    },
    updated() {
        this.updateData('galleries', this.form);
    },
    created() {
        if(!this.item) {
            this.form = {
                galleries: {}
            }
        } else {
            this.form = this.item;
            this.galleries = !Array.isArray(this.form.galleries) ? this.form.galleries : {}
        }
        if (this.editorConfig) {
            this.editorConfigData = this.editorConfig;
            this.editorConfigData.extraPlugins = [this.meyCustomUploadAdapterPlugin];
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
                this.form = this.item;
                this.galleries = !Array.isArray(this.form.galleries) ? this.form.galleries : {}
            }
        }
    },
    methods: {
        updateDataElementData (moduleName, form) {
            this.form[moduleName] = form
            this.updateData('galleries', this.form);
        },
        meyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        },
        updateMultipleInput () {
            this.setMultipleFields()
        },
        setMultipleFields () {
            this.form.galleries = this.galleries
        },
        removeAttributeOption(idx, module = 'galleries') {
            if(module === 'galleries') {
                this.galleries.splice(idx, 1);
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
