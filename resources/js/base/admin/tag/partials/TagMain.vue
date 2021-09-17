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
                                <label class="col-md-1 control-label">{{ lang.tag_name }}:</label>
                                <div class="col-md-10 uppercase-medium">
                                    <input class="form-control" :disabled="loading" v-model="form.name">
                                </div>
                            </div>

                            <div class="form-group dashed">
                                <label class="col-md-1 control-label">{{ lang.tag_locale }}:</label>
                                <div class="col-md-10 uppercase-medium">
                                    <el-select
                                        v-model="form.locale"
                                        clearable
                                        filterable
                                        :placeholder="lang.tag_locale">
                                        <el-option
                                            v-for="locale in locales"
                                            :key="locale"
                                            :label="locale"
                                            :value="locale">
                                        </el-option>
                                    </el-select>
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
            'item',
            'locales'
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
