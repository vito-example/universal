<template>
    <div>
        <vue-collapsible-panel-group
                v-if="companies.length"
                base-color="#9DBF53"
        >
            <vue-collapsible-panel :expanded="false" v-for="(company,index) in companies" v-if="!!companies"
                                   :key="`panel-${index}`">
                <template #title>
                    <p
                            class="color-black font-size-sm"
                    >
                                                        <span>
                                                            {{ company.title }}
                                                        </span>
                    </p>
                </template>
                <template #content>
                    <div v-for="(employee,index) in company.employees"
                         v-if="company.employees.length"
                         :key="`employee-${index}-${employee.name}`"
                         class="flex space-between margin-bottom-28">
                        <div>
                            {{ employee.name }}
                        </div>

                        <div>
                            <button
                                    type="button"
                                    class="button button--link color-black text-decoration-none"
                                    @click="handleShowEditColleague(employee)"

                            >
                                <edit-icon width="24" height="24"/>
                            </button>

                            <button
                                    type="button"
                                    class="button button--link color-black text-decoration-none margin-left-16"
                                    @click="handleShowDeletePopup(route('employee.destroy',employee.id))"
                            >
                                <delete-icon width="24" height="24"/>
                            </button>
                        </div>
                    </div>
                    <div v-else class="flex space-between margin-bottom-28">
                        <div>
                            {{ __('თანამშრომელი არ მოიძებნა') }}
                        </div>

                    </div>

                </template>
            </vue-collapsible-panel>
        </vue-collapsible-panel-group>
        <div v-else>
            {{ __('თანამშრომელი არ მოიძებნა') }}
        </div>
        <hr>

        <button
                type="button"
                v-if="companies.length"
                class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                @click="handleShowNewColleague"
        >
            {{ __('ახალი თანამშრომლის დამატება') }}
        </button>

        <new-colleague-popup/>
        <edit-colleague-popup/>
        <delete-popup/>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus"
import EditIcon from "@/Components/Web/Icons/Edit"
import DeleteIcon from "@/Components/Web/Icons/Delete"
import NewColleaguePopup from "@/Components/Web/Popup/NewColleague"
import EditColleaguePopup from "@/Components/Web/Popup/EditColleague"
import DeletePopup from "@/Components/Web/Popup/Delete"
import "@dafcoe/vue-collapsible-panel/dist/vue-collapsible-panel.css"
import {
    VueCollapsiblePanelGroup,
    VueCollapsiblePanel,
} from "@dafcoe/vue-collapsible-panel"

export default {
    components: {
        EditIcon,
        DeleteIcon,
        NewColleaguePopup,
        EditColleaguePopup,
        DeletePopup,
        VueCollapsiblePanelGroup,
        VueCollapsiblePanel
    },

    props: {
        companies: {
            type: Array
        }
    },

    data () {
        return {
            renderEmployee: true
        }
    },

    methods: {
        handleShowDeletePopup(route) {
            emitter.emit('showDeletePopup', route)
        },

        handleShowNewColleague() {
            emitter.emit('showNewColleaguePopup', this.companies)
        },

        handleShowEditColleague(employee) {
            emitter.emit('showEditColleaguePopup', {
                employee: employee,
                companies: this.companies
            })
        }
    }
}
</script>