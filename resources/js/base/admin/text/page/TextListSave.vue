<template>

    <div>
        <div>
            <AddLang
                :trans_text="trans_text"
                :routes="routes"
                :groups="groups"
                :activeLocale="activeTabName"
                :locales="all_locales"
                :getIndexBaseData="getIndexBaseData"
            ></AddLang>
            <ImportLang
                :trans_text="trans_text"
                :routes="routes"
                :getIndexBaseData="getIndexBaseData">
            </ImportLang>
            <el-button
                icon="el-icon-refresh"
                style="margin-bottom: 2rem;"
                type="warning"
                class="pull-right"
                @click="updateText({},true)">
                {{ trans_text.update_all }}
            </el-button>
            <el-button
                icon="el-icon-document"
                style="margin-bottom: 2rem; margin-right: 3rem;"
                type="secondary"
                class="pull-right"
                @click="exportTexts()">
                {{ trans_text.export }}
            </el-button>
        </div>
        <div class="block">
        <el-form class="form-horizontal form-bordered"  v-loading="loading"
                 element-loading-text="Loading..."
                 element-loading-spinner="el-icon-loading"
                 element-loading-background="rgba(0, 0, 0, 0.8)"
                 @submit.native.prevent :model="form" label-width="200px">

            <el-tabs v-model="activeTabName">

                    <el-tab-pane  class="" :label="activeTabName" :name="activeTabName">
                        <div class="table-responsive">
                            <table class="table table-vcenter table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">
                                        <el-select @change="changeTotal" filterable allow-create v-model="form.total">
                                            <el-option :key="1" :label="25" :value="25"></el-option>
                                            <el-option :key="2" :label="50" :value="50"></el-option>
                                            <el-option :key="3" :label="100" :value="100"></el-option>
                                        </el-select>
                                    </th>
                                    <th>
                                        <el-input
                                            @keyup.enter.native="getIndexBaseData()"
                                            @change="getIndexBaseData()"
                                        :placeholder="trans_text.filter_key"
                                        clearable
                                        v-model="form.key">
                                        </el-input>
                                    </th>
                                    <th v-for="loc in all_locales">
                                        <el-input
                                            type="textarea"
                                            @keyup.enter.native="getIndexBaseData()"
                                            @change="getIndexBaseData()"
                                            clearable
                                            :placeholder="loc"
                                            v-model="form[loc]">
                                        </el-input>
                                    </th>
                                    <th width="10%" class="text-center">
                                        <el-tag type="info"> {{ lang_files_paginate.total }}</el-tag>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="5%">{{ trans_text.file_name }}</th>
                                    <th width="5%">{{ trans_text.key }}</th>
                                    <th v-for="loc in all_locales">{{ loc }}</th>
                                    <th width="10%" class="text-center">{{ trans_text.actions }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="(file_text, key) in lang_files">
                                    <tr>
                                        <td>{{ activeTabName }}</td>
                                        <td>{{ key }}</td>
                                        <template v-for="loc in all_locales">
                                            <td>
                                                <el-input
                                                    type="textarea"
                                                    @keyup.enter.native="updateText({file: activeTabName, key: key, text: file_text})"
                                                    :placeholder="loc"
                                                    v-model="lang_files[key][loc]">
                                                </el-input>
                                            </td>
                                        </template>
                                        <td class="text-center">
                                            <el-button
                                                @click="updateText({file: activeTabName, key: key, text: file_text})"
                                                :title="trans_text.edit_title"
                                                size="small"
                                                type="success"
                                                icon="el-icon-check"
                                            ></el-button>
                                            <el-button
                                                @click="deleteText({file: activeTabName, key: key})"
                                                :title="trans_text.delete_title"
                                                size="small"
                                                type="danger"
                                                icon="el-icon-delete">
                                            </el-button>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                                <el-pagination
                                    @current-change="changePage"
                                    layout="prev, pager, next"
                                    :total="lang_files_paginate.total"
                                    :page-size="parseInt(lang_files_paginate.per_page)"
                                    :current-page="form.page ? parseInt(form.page) : lang_files_paginate.current_page">
                                </el-pagination>
                            </table>
                        </div>
                    </el-tab-pane>

                <template v-for="group in groups">
                    <el-tab-pane  class="" :label="group" :name="group">
                    </el-tab-pane>
                </template>

            </el-tabs>


        </el-form>

    </div>
    </div>
</template>

<script>

    import {getData} from '../../../mixins/getData'
    import {responseParse} from '../../../mixins/responseParse'
    import AddLang from "../partials/AddLang";
    import ImportLang from "../partials/ImportLang";

    export default {
        components: {ImportLang, AddLang},
        props: [
            'indexDataRoute'
        ],
        data(){
            return {
                loading: false,
                form: {
                    total: 25
                },
                activeTabName: 'admin',
                lang_files: [],
                trans_text: {},
                all_locales: [],
                routes: {},
                groups: {},
                lang_files_paginate: {}
            }
        },
        created(){
            this.form.group = this.activeTabName
            this.getIndexBaseData();
        },
        watch: {
            'activeTabName' () {
                this.form.group = this.activeTabName
                this.form = {...this.form, ...{page: 1}};
                this.getIndexBaseData();
            }
        },
        methods: {

            /**
             * Delete text.
             */
            async deleteText(form){
                this.loading = true;

                this.$confirm(this.trans_text.delete_confirm, {
                    confirmButtonText: this.trans_text.delete_confirm_yes,
                    cancelButtonText: this.trans_text.delete_confirm_no,
                    type: 'warning'
                })
                    .then(async () => {

                        await getData({
                            method: 'POST',
                            url: this.routes.delete,
                            data: form
                        }).then(response => {
                            // Parse response notification.
                            responseParse(response);
                            if (response.status == 200) {
                                delete this.lang_files[form.key];
                            }
                            this.loading = false;
                        })
                    }).catch(() => {
                    this.loading = false;
                });

            },

            /**
             * Save text.
             */
            async updateText(form = {}, saveAll = false){
                this.loading = true;
                let formData = {
                    texts: {}
                };

                if (!saveAll) {
                    formData.texts[form.key] = form.text
                } else {
                    formData.texts = this.lang_files
                }

                formData.file = this.activeTabName;

                await getData({
                    method: 'POST',
                    url: this.routes.update,
                    data: formData
                }).then(response => {
                    // Parse response notification.
                    responseParse(response);
                    if (response.status == 200) {
                        if (saveAll) {
                            this.getIndexBaseData();
                        }
                    }
                    this.loading = false;
                })
            },

            changePage(val) {
                this.form = {...this.form, ...{page: val}};
                this.getIndexBaseData();
                window.scrollTo(0, 0);
            },

            exportTexts() {
                let queryString = '';
                if (this.form) {
                    queryString = Object.keys(this.form).map(key => key + '=' + this.form[key]).join('&')
                }
                window.location.href = this.routes.export + '?' + queryString;
            },

            changeTotal() {
                this.form = {...this.form, ...{page: 1}};
                this.getIndexBaseData();
            },

            /**
             *
             * @returns {Promise<void>}
             */
            async getIndexBaseData(){
                this.loading = true;

                await getData({
                    method: 'POST',
                    url: this.indexDataRoute,
                    data: this.form
                }).then(response => {
                    // Parse response notification.
                    responseParse(response, false);
                    if (response.status == 200) {
                        let data = response.data.data;

                        this.lang_files_paginate = data.lang_files;
                        this.lang_files = data.lang_files.data;
                        this.trans_text = data.trans_text;
                        this.all_locales = data.locales;
                        this.routes = data.routes;
                        this.groups = data.groups;
                    }
                    this.loading = false;
                })
            },

        }

    }

</script>
