<template>
    <div>
        <div class="col-xs-12">
            <div class="registration-btn project-title-buttons">

                <div class="project-title">

                </div>

                <div class="project-buttons">
                    <el-button type="primary" size="medium" icon="el-icon-check"
                               @click="save"
                               :disabled="loading"
                               style="margin: 21px 1rem">{{ lang.save_text }}
                    </el-button>
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
                            <i class="el-icon-folder-opened"></i>
                        </span>

                        <main-form
                            :default-locale="default_locale"
                            :locales="locales"
                            :editor-config="editorConfig"
                            :lang="lang"
                            :routes="routes"
                            :options="options"
                            :updateData="updateData"
                            :item="this.form && this.form.main ? this.form.main : undefined"
                        ></main-form>

                    </el-tab-pane>


                    <el-tab-pane :label="lang.seo_tab" key="event_seo" name="event_seo">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.seo_tab" placement="top-start">
                                <i class="el-icon-setting"></i>
                            </el-tooltip>
                        </span>
                        <blog-seo
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.seo_meta ? this.form.seo_meta : undefined">
                        </blog-seo>
                    </el-tab-pane>

                </el-tabs>

            </div>
        </div>
    </div>
</template>

<script>

import {responseParse} from '../../mixins/responseParse'
import {getData} from '../../mixins/getData'
import MainForm from "./partials/MainForm";
import BlogSeo from "./partials/BlogSeo";

export default {
    components: {MainForm, BlogSeo},
    props: [
        'getSaveDataRoute',
        'id'
    ],
    data() {
        return {
            default_locale: '',
            item: {},
            data: {},
            loading: false,
            lang: {},
            routes: {},
            options: {},
            locales: [],
            /**
             * Form data
             */
            form: {
                id: this.id
            },
            tabValue: 'main',
            editorConfig: {}
        }
    },
    created() {
        this.getSaveData();
    },
    methods: {
        /**
         *
         * Get save data.
         *
         * @returns {Promise<void>}
         */
        async getSaveData() {
            this.loading = true;

            await getData({
                method: 'POST',
                url: this.getSaveDataRoute,
                data: this.form
            }).then(response => {
                // Parse response notification.
                responseParse(response, false);

                if (response.status === 200) {
                    // Response data.
                    let data = response.data.data;

                    this.lang = data.trans_text;
                    this.routes = data.routes;
                    this.options = data.options;
                    this.default_locale = data.default_locale;
                    this.locales = data.locales;
                    this.editorConfig = data.editor_config
                    if (data.item) {
                        this.form = data.item;
                    }
                    this.form.id = this.id;
                }
                this.loading = false
            })
        },

        async save() {
            this.loading = true;
            await getData({
                method: 'POST',
                url: this.routes.save,
                data: this.form
            }).then(response => {
                // Parse response notification.
                responseParse(response);

                if (response.status == 200) {
                    // Response data.
                    let data = response.data.data;
                    setTimeout(() => {
                        window.location.reload();
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
