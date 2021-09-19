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
                                    <label class="col-md-2 control-label"><span
                                        class="text-danger">*</span>{{ lang.meta_title }} <span class="grey">{{
                                            locale
                                        }}</span>:</label>
                                    <div class="col-md-10 uppercase-medium">
                                        <input class="form-control" maxlength="150"
                                               :disabled="loading"
                                               v-model="form[locale].title">
                                    </div>
                                </div>
                                <div class="form-group dashed">
                                    <label class="col-md-2 control-label">{{ lang.meta_description }} <span
                                        class="grey">{{
                                            locale
                                        }}</span>:</label>
                                    <div class="col-md-4 uppercase-medium">
                            <textarea class="form-control"
                                      rows="5"
                                      cols="5"
                                      :disabled="loading"
                                      v-model="form[locale].description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group dashed">
                                    <label class="col-md-2 control-label">{{ lang.meta_keyword }} <span class="grey">{{
                                            locale
                                        }}</span>:</label>
                                    <div class="col-md-4 uppercase-medium">
                            <textarea class="form-control"
                                      rows="5"
                                      cols="5"
                                      :disabled="loading"
                                      v-model="form[locale].keyword"></textarea>
                                    </div>
                                </div>
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
import moment from 'moment';

export default {
    props: [
        'lang',
        'locales',
        'defaultLocale',
        'routes',
        'updateData',
        'item',
    ],
    data() {
        return {
            form: {},
            activeTabName: '',
            loading: false,
        }
    },
    updated() {
        this.updateData('seo_meta', this.form);
    },
    watch: {
        'defaultLocale'(){
            this.activeTabName = this.defaultLocale;
        },
        'locales'() {
            if (!this.item || Object.keys(this.item).length === 0) {
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
            }
        }
    }
}

</script>
