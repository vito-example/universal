<template>
    <span>
        <el-button
            icon="el-icon-document-add"
            style="margin-bottom: 2rem;"
            type="success"
            @click="modal(true)">
            {{ trans_text.import }}
        </el-button>
        <el-drawer
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0.8)"
            :title="trans_text.import_title"
            v-model="dialogVisible"
            size="50%"
            direction="btt"
            custom-class="demo-drawer"
            ref="drawer"
            :before-close="handleClose">
          <div class="demo-drawer__content">
                <el-form :model="form">
                    <el-row>
                      <el-col :span="24">
                             <div class="form-group">
                                <label class="col-md-2 control-label">{{ trans_text.upload_import_file }}</label>
                                <div class="col-md-6">
                                    <input style="display: block !important;" ref="file" type="file"/>
                                </div>
                             </div>
                      </el-col>
                    </el-row>
                </el-form>
                <div class="demo-drawer__footer">
                  <el-button @click="modal(false)">{{ trans_text.cancel_import_file }}</el-button>
                  <el-button type="primary" @click="saveFile" :disabled="loading" :loading="loading">{{ trans_text.import_file }}</el-button>
                </div>
          </div>
        </el-drawer>
    </span>
</template>

<style>
.demo-drawer{
    overflow: scroll;
}
</style>
<script>
import {getData} from '../../../mixins/getData'
import {responseParse} from '../../../mixins/responseParse'

export default {

    props: [
        'trans_text',
        'routes',
        'getIndexBaseData'
    ],
    data() {
        return {
            loading: false,
            dialogVisible: false,
            form: {
                file: ''
            },
            formLabelWidth: '200px'
        }
    },
    methods: {
        async saveFile () {
            this.loading = true
            let file = this.$refs.file.files[0];

            var data = new FormData();
            data.append('file', file);

            await getData({
                method: 'POST',
                url: this.routes.import,
                data: data
            }).then(response => {
                // Parse response notification.
                responseParse(response);
                if (response.status == 200) {
                    this.getIndexBaseData();
                    this.modal(false);
                }
                this.loading = false
            }).catch((e) => {
                this.loading = false
            });
            this.loading = false
        },
        /**
         *
         * @param done
         */
        handleClose(done) {
            done();
        },
        /**
         * Modal close/show
         */
        modal(status = true) {
            this.dialogVisible = status;
        },
    }
}
</script>
