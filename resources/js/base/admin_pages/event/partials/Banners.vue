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
                                :item="banners"
                                :routes="routes"
                                :options="options"
                                :update-data="updateDataElementData"
                                :all-fields="options.banners_attributes ? options.banners_attributes : []"
                                :module-name="'banners'"
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
import MembersRepeater from "@/base/admin_pages/event/partials/MembersRepeater";

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
            banners: []
        }
    },
    updated() {
        this.updateData('banners', this.form);
    },
    created() {
        if(!this.item) {
            this.form = {
                banners: {}
            }
        } else {
            this.form = this.item;
            this.banners = !Array.isArray(this.form.banners) ? this.form.banners : {}
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
        'organizers'(){
            this.form.banners = this.banners
        },
        'item'() {
            if (this.item) {
                this.form = this.item;
                this.banners = !Array.isArray(this.form.banners) ? this.form.banners : {}
            }
        }
    },
    methods: {
        updateDataElementData (moduleName, form) {
            this.form[moduleName] = form
            this.updateData('banners', this.form);
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
            this.form.banners = this.banners
        },
        removeAttributeOption(idx, module = 'banners') {
            if(module === 'banners') {
                this.banners.splice(idx, 1);
            }
        },
        /**
         * Add attribute option.
         */
        addAttributeOption(module = 'organizers') {
            if(module === 'organizers') {
                this.organizers.push({ name: ''});
            } else if (module === 'speakers') {
                this.speakers.push({ name: ''});
            } else if (module === 'sponsors') {
                this.sponsors.push({ name: ''});
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
