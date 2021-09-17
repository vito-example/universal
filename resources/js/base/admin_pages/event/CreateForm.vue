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

                    <el-tab-pane :label="lang.main_tab" key="main" name="main">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.main_tab" placement="top-start">
                                <i class="el-icon-folder-opened"></i>
                            </el-tooltip>
                        </span>

                        <main-form
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :directions="directions"
                            :updateData="updateData"
                            :item="this.form && this.form.main ? this.form.main : undefined"
                        ></main-form>

                    </el-tab-pane>

                    <el-tab-pane :label="lang.options_tab" key="event_options" name="event_options">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.options_tab" placement="top-start">
                                <i class="el-icon-setting"></i>
                            </el-tooltip>
                        </span>

                        <event-options
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            @changeTrainingType="trainingPlanedChange"
                            :options="options"
                            :routes="routes"
                            :trainigPlaned="trainingPlaned"
                            :updateData="updateData"
                            :item="this.form && this.form.options ? this.form.options : undefined">
                        </event-options>

                    </el-tab-pane>

                    <el-tab-pane :label="lang.event_sessions" key="sessions" name="sessions">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.event_sessions" placement="top-start">
                                <i class="el-icon-picture"></i>
                            </el-tooltip>
                        </span>

                        <event-session
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.event_sessions ? this.form.event_sessions : undefined">
                        </event-session>

                    </el-tab-pane>


                    <el-tab-pane :label="lang.event_humans" key="humans" name="humans">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.event_humans" placement="top-start">
                                <i class="el-icon-user-solid"></i>
                            </el-tooltip>
                        </span>

                        <event-human
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.humans ? this.form.humans : undefined">
                        </event-human>

                    </el-tab-pane>

                    <el-tab-pane :label="lang.gallery_tab" key="banners" name="banners">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.banners_tab" placement="top-start">
                                <i class="el-icon-picture"></i>
                            </el-tooltip>
                        </span>

                        <banners
                            :editorConfig="editorConfig"
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.banners ? this.form.banners : undefined">
                        </banners>

                    </el-tab-pane>

                    <el-tab-pane :label="lang.seo_tab" key="event_seo" name="event_seo">
                        <!--Label-->
                        <span slot="label">
                            <el-tooltip class="item" effect="dark" :content="lang.seo_tab" placement="top-start">
                                <i class="el-icon-setting"></i>
                            </el-tooltip>
                        </span>

                        <event-seo
                            :default-locale="default_locale"
                            :locales="locales"
                            :lang="lang"
                            :options="options"
                            :routes="routes"
                            :updateData="updateData"
                            :item="this.form && this.form.seo_meta ? this.form.seo_meta : undefined">
                        </event-seo>

                    </el-tab-pane>

                </el-tabs>


            </div>
            <div class="project-buttons">
                <el-button type="primary"
                           size="medium"
                           icon="el-icon-check"
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
import MainForm from "./partials/MainForm";
import EventOptions from "@/base/admin_pages/event/partials/EventOptions";
import EventHuman from "@/base/admin_pages/event/partials/EventHuman";
import Banners from "@/base/admin_pages/event/partials/Banners";
import EventSession from "./partials/EventSession";
import EventSeo from "./partials/EventSeo";

export default {
    components: {Banners, EventHuman, EventOptions, MainForm, EventSession, EventSeo},
    props: [
        'getSaveDataRoute',
        'id',
        'tabKey'
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
            directions: {},
            locales: [],
            editorConfig: {},
            /**
             * Form data
             */
            form: {
                id: this.id
            },
            trainingPlaned: true,
            tabValue: this.tabKey ? this.tabKey : 'main'
        }
    },
    created() {
        this.getSaveData();
        this.tabValue = this.tabKey ? this.tabKey : 'main'
    },
    methods: {
        trainingPlanedChange(trainingTypeValue) {
          // this.trainingPlaned = trainingTypeValue === 100;
            console.log('training type changed...')
        },
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
                    this.directions = data.directions;
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

                if (response.status === 200) {
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
