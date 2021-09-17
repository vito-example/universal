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
                        <label class="col-md-2 control-label">{{ lang.employees }}</label>
                        <div class="col-md-10">
                            <employees-repeater
                                :items="items"
                                :routes="routes"
                                :update-data="updateDataElementData"
                                :lang="lang">
                            </employees-repeater>
                        </div>
                    </div>
                </div>
            </el-form>
        </div>
    </div>
</template>


<script>
import EmployeesRepeater from "./EmployeesRepeater";

export default {
    components: {EmployeesRepeater},
    props: [
        'lang',
        'routes',
        'updateData',
        'items',
    ],
    data() {
        return {
            form: {},
            activeTabName: '',
            loading: false,
        }
    },
    updated() {
        this.updateData('employees', this.form);
    },
    watch: {
        'items'() {
            if (this.items && this.items.length) {
                this.updateDataElementData('employees',this.items)
            }
        }
    },
    methods: {
        updateDataElementData(moduleName = 'employees', form) {
            this.form = form
            this.updateData(moduleName, this.form);
        },
    }
}

</script>
