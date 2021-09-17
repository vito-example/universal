<template>
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
                            class="text-danger">*</span>{{ lang.name }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.name">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger">*</span>{{ lang.email }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.email">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger"></span>{{ lang.phone }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.phone">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger"></span>{{ lang.role }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.role">
                        </div>
                    </div>
                    <div class="form-group dashed">
                        <label class="col-md-2 control-label"><span
                            class="text-danger"></span>{{ lang.specialty }}:</label>
                        <div class="col-md-4 uppercase-medium">
                            <input class="form-control" maxlength="150"
                                   :disabled="loading"
                                   v-model="form.specialty">
                        </div>
                    </div>
                </div>
            </el-form>
        </div>
    </div>
</template>


<script>

export default {
    props: [
        'lang',
        'routes',
        'updateData',
        'item',
    ],
    data() {
        return {
            form: {},
            loading: false,
            selectLoading: false,
        }
    },
    updated() {
        this.updateData('main', this.form);
    },
    watch: {
        'item'() {
            if (this.item) {
                this.form = this.item;
                this.optionsData = this.options
            }
        }
    }
}

</script>
