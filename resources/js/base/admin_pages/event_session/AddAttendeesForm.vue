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

                        <div>
                            <div class="block">
                                <el-form v-loading="loading"
                                         element-loading-text="Loading..."
                                         element-loading-spinner="el-icon-loading"
                                         element-loading-background="rgba(0, 0, 0, 0.0)"
                                         ref="form" :model="form" class="form-horizontal form-bordered">

                                    <div class="row">
                                        <div class="form-group dashed">
                                            <label class="col-md-2 control-label"><span
                                                class="text-danger">*</span>{{ trans.attendees }}:</label>
                                            <div class="col-md-10 uppercase-medium">
                                                <el-select
                                                    filterable
                                                    remote
                                                    multiple
                                                    reserve-keyword
                                                    :loading="selectLoaidng"
                                                    :remote-method="query => filterEntity(query)"
                                                    v-model="form.attendees"
                                                    :placeholder="trans.attendees">
                                                    <el-option
                                                        v-for="(item,key) in this.options"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>
                                </el-form>
                            </div>
                        </div>

                    </el-tab-pane>
                </el-tabs>


            </div>
            <div class="project-buttons">
                <el-button  type="primary"
                            size="medium"
                            icon="el-icon-check"
                            @click="save"
                            :disabled="loading"
                            style="margin: 15px 0 30px 0px">{{ trans.save_text }}
                </el-button>
            </div>
        </div>
    </div>
</template>

<script>

import {responseParse} from '../../mixins/responseParse'
import {getData} from '../../mixins/getData'

export default {
    props: [
        'optionsAttendees',
        'id',
        'tabKey',
        'attendees',
        'lang',
        'saveRoute',
        'searchRoute'
    ],
    data() {
        return {
            form: {
                id: this.id,
                attendees: JSON.parse(this.attendees)
            },
            trans: JSON.parse(this.lang),
            options: JSON.parse(this.optionsAttendees),
            tabValue: this.tabKey ? this.tabKey : 'main',
        }
    },
    methods: {
        async filterEntity(query) {
            console.log(this.options)
            if (query.length < 2) {
                return ''
            }
            this.selectLoading = true
            await getData({
                method: 'GET',
                url: this.searchRoute,
                data: {
                    q: query
                }
            }).then(response => {
                responseParse(response, false);
                console.log(response)
                if (response.status === 200) {
                    let data = [...this.options, ...response.data.data.items];
                    this.options = Array.from(new Set(data.map(JSON.stringify))).map(JSON.parse);
                }
                this.selectLoading = false
            });
        },
        async save(){
            this.loading = true;
            await getData({
                method: 'POST',
                url: this.saveRoute,
                data: this.form
            }).then(response => {
                // Parse response notification.
                responseParse(response);
                console.log(response)
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
