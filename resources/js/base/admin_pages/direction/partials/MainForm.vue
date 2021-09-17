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
                                        <label class="col-md-2 control-label">{{ lang.parent }}:</label>
                                        <div class="col-md-4 uppercase-medium">
                                            <el-select v-model="form.parent_id" filterable  :placeholder="lang.parent">
                                                <el-option
                                                    v-for="(item,key) in options.directions"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                <div class="form-group dashed">
                                    <label class="col-md-2 control-label"><span class="text-danger">*</span>{{ lang.title }} <span class="grey">{{ locale }}</span>:</label>
                                    <div class="col-md-10 uppercase-medium">
                                        <input class="form-control" maxlength="150"
                                               :disabled="loading"
                                               v-model="form[locale].title">
                                    </div>
                                </div>

                                <template v-if="locale == defaultLocale">

                                    <div class="form-group" style="text-align: right;display: flex;align-items: center;">
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-10" style="padding-top: 11px;">
                                            <el-radio-group v-model="form.status">
                                                <el-radio-button :label="1">{{ lang.status_yes }}</el-radio-button>
                                                <el-radio-button :label="0">{{ lang.status_no }}</el-radio-button>
                                            </el-radio-group>
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
        data(){
            return {
                form: {
                },
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
                }
            }
        },
    }

</script>
