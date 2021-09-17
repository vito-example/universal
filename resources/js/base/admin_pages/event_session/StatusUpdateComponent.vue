<template>
    <span>
        <span>{{ statusLabel }}</span>
        <el-button title="სტატუსის ცვლილება" @click="modalToggle" icon="el-icon-s-help" size="small" type="secondary"></el-button>
        <el-dialog
            :title="lang.status_update_title"
            v-model="dialogVisible"
            width="50%"
            :before-close="handleClose">
            <h4>{{ item.title }}</h4><br>
                <div
                    class="row mt-3"
                    v-loading="loading"
                    element-loading-text="Loading..."
                    element-loading-spinner="el-icon-loading"
                    element-loading-background="rgba(0, 0, 0, 0.0)">
                    <el-form :model="form">
                        <el-form-item :label="lang.status" label-width="180px">
                            <el-select v-model="form.status" :placeholder="lang.status">
                                <el-option
                                    v-for="item in options.statuses"
                                    :label="item.label" :value="item.value"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-form>
                </div>
              <template #footer>
                <span class="dialog-footer">
                  <el-button @click="dialogVisible = false">{{ lang.close }}</el-button>
                  <el-button type="primary" @click="updateStatus">{{ lang.update_status_button }}</el-button>
                </span>
              </template>
        </el-dialog>
    </span>
</template>

<script>

import {notifications} from "@/base/mixins/notifications";
import {getData} from "@/base/mixins/getData";
import {responseParse} from "@/base/mixins/responseParse";

export default {
    props: [
        'url',
        'id',
        'eventSessionStatus',
        'status'
    ],

    data() {
        return {
            dialogVisible: false,
            form: {
                status: this.status
            },
            lang: {},
            routes: {},
            loading: false,
            item: {},
            options: {},
            statusLabel: this.eventSessionStatus
        }
    },
    watch: {
        'dialogVisible'() {
            if (this.dialogVisible) {
                this.getStatusData()
            }
        }
    },
    methods: {
        modalToggle() {
            this.dialogVisible = !this.dialogVisible
        },
        async getStatusData() {
            this.loading = true
            await getData({
                method: 'GET',
                url: this.url,
                data: {id: this.id}
            }).then(response => {
                // Parse response notification.
                responseParse(response, false);
                if (response.status == 200) {
                    // Response data.
                    let data = response.data.data
                    this.lang = data.trans_text
                    this.routes = data.routes
                    this.options = data.options
                    this.item = data.item
                    this.form.statusLabel = this.item.status_label
                }
                this.loading = false;
            })
        },
        /**
         * Generate token.
         */
        updateStatus() {
            this.$confirm(this.lang.sure_update_status, 'Attention!', {
                confirmButtonText: this.lang.sure_update_status_yes,
                cancelButtonText: this.lang.sure_update_status_yessure_generate_token_no,
                type: 'warning'
            }).then(async () => {
                this.loading = true;

                await getData({
                    method: 'POST',
                    url: this.routes.update_status,
                    data: {id: this.id, status: this.form.status}
                }).then(response => {
                    responseParse(response);
                    if (response.status === 200) {
                        this.handleClose()
                        this.statusLabel = response.data.data.status_label
                    }
                    this.loading = false;
                })

            });

        },
        handleClose() {
            this.modalToggle()
        },
    }
}

</script>
