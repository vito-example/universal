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

                    <el-tab-pane key="meta" name="meta">
                        <!--Label-->
                        <span slot="label">
                            <i class="el-icon-folder-opened"></i>
                        </span>

                        <single-elements
                            v-if="type === 'home'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'project'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'blog'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>


                        <single-elements
                            v-if="type === 'about'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'contact'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'team'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'social'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'seo'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'setting'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                        <single-elements
                            v-if="type === 'service'"
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.meta ? this.form.meta : undefined">
                        </single-elements>

                    </el-tab-pane>

                </el-tabs>

            </div>
            <div class="project-buttons">
                <el-button type="primary" size="medium" icon="el-icon-check"
                           @click="save"
                           :disabled="loading"
                           style="margin: 15px 0 30px 0px">{{ lang.save_text }}
                </el-button>
            </div>
        </div>
    </div>
</template>

<script>

import {responseParse} from '../../mixins/responseParse'
import {getData} from '../../mixins/getData'
import MultipleElements from "@/base/admin_pages/page_meta/partials/MultipleElements";
import SingleElements from "@/base/admin_pages/page_meta/partials/SingleElements";
import Home from "@/base/admin_pages/page_meta/partials/Home";

export default {
    components: {
        SingleElements,
        MultipleElements,
        Home
    },
    props: [
        'getSaveDataRoute',
        'id',
        'type'
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
            editorConfig: {},
            /**
             * Form data
             */
            form: {
                type: this.type
            },
            tabValue: 'meta'
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

                if (response.status == 200) {
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

        async save(){
            this.loading = true;
            this.form.type = this.type

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
                    },1000);
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
