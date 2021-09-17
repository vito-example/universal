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
                        <label class="col-md-2 control-label">{{ lang.sessions }}</label>
                        <div class="col-md-10">
                            <members-repeater
                                :editorConfig="editorConfig"
                                :item="sessions"
                                :routes="routes"
                                :options="options"
                                :update-data="updateDataElementData"
                                :all-fields="options.sessions_attributes ? options.sessions_attributes.sessions : []"
                                :module-name="'sessions'"
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
            sessions: [],
        }
    },
    updated() {
        this.updateData('event_sessions', this.form);
    },
    created() {
        if (!this.item) {
            this.form = {
                sessions: {},
            }
        } else {
            this.form = this.item;
            this.sessions = !Array.isArray(this.form.sessions) ? this.form.sessions : {}
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
                this.sessions = !Array.isArray(this.form.sessions) ? this.form.sessions : {}
            }
        }
    },
    methods: {
        updateDataElementData(moduleName, form) {
            this.form[moduleName] = form
            this.updateData('event_sessions', this.form);
        },
        removeAttributeOption(idx, module = 'sessions') {
            if (module === 'sessions') {
                this.sessions.splice(idx, 1);
            }
        },
        /**
         * Add attribute option.
         */
        addAttributeOption(module = 'sessions') {
            if (module === 'sessions') {
                this.sessions.push({name: ''});
            }
        },
    }
}

</script>
