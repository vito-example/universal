<template>
    <div>
        <div class="block" >
            <el-form v-loading="loading"
                     element-loading-text="Loading..."
                     element-loading-spinner="el-icon-loading"
                     element-loading-background="rgba(0, 0, 0, 0.0)"
                     ref="form" :model="form" class="form-horizontal form-bordered">

                        <el-row>

                            <div class="form-group dashed">
                                <label class="col-md-1 control-label">{{ lang.url }}:</label>
                                <div class="col-md-10 uppercase-medium">
                                    <input class="form-control" :disabled="loading" v-model="form.url">
                                </div>
                            </div>

                            <div class="form-group editor-large" v-if="form.slugable">
                                <label class="col-md-1 control-label">{{ lang.module }}:</label>
                                <div class="col-md-10">
                                    <a :href="form.slugable ? form.slugable.edit_page_url : ''" target="_blank">{{ form.module }}</a>
                                </div>
                            </div>

                            <div class="form-group editor-large" v-if="form.previous_urls">
                                <label class="col-md-1 control-label">{{ lang.previous_urls }}:</label>
                                <div class="col-md-10">
                                    <ul>
                                        <li v-for="url in form.previous_urls">
                                            {{ url }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group editor-large">
                                <label class="col-md-1 control-label">{{ lang.redirect_url }}:</label>
                                <div class="col-md-10">
                                    <input class="form-control" :disabled="loading" v-model="form.redirect_url">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ lang.status }}</label>
                                <div class="col-md-6" style="padding-top: 11px;">
                                    <el-radio v-model="form.status" :label="1">{{ lang.status_yes }}</el-radio>
                                    <el-radio v-model="form.status" :label="0">{{ lang.status_no }}</el-radio>
                                </div>
                            </div>
                        </el-row>
            </el-form>
        </div>
    </div>
</template>


<script>
import {responseParse} from '../../../mixins/responseParse'
import {getData} from '../../../mixins/getData'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        props: [
            'lang',
            'routes',
            'updateData',
            'item'
        ],
        data(){
            return {
                form: {},
                loading: false,
                editor: ClassicEditor,
            }
        },
        updated() {
            this.updateData('main', this.form);
        },
        watch: {
            'item'(){
                if (this.item) {
                    this.form = this.item;
                }
            }
        },
        methods: {
        }
    }

</script>
