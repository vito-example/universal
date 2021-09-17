<template>
    <div>
        <div class="flex space-between margin-bottom-28" v-for="(company, index) in companies"
             v-if="companies.length">
            <div>
                {{ company.title }}
            </div>

            <div>
                <button
                        type="button"
                        class="button button--link color-black text-decoration-none"
                        @click="handleShowEditCompany(company)"

                >
                    <edit-icon width="24" height="24"/>
                </button>

                <button
                        type="button"
                        class="button button--link color-black text-decoration-none margin-left-16"
                        @click="handleShowDeletePopup(route('company.destroy', company.id))"
                >
                    <delete-icon width="24" height="24"/>
                </button>
            </div>
        </div>
        <div class="flex space-between margin-bottom-28" v-else>
            <div>
                {{ __('კომპანია არ მოიძებნა') }}
            </div>
        </div>

        <hr>

        <button
                type="button"
                class="button button--link color-black font-size-xs font-weight-600 text-decoration-none flex items-center margin-top-24"
                @click="handleShowNewCompany"
        >
            {{ __('ახალი კომპანიის დამატება') }}
        </button>

        <new-company-popup/>
        <edit-company-popup/>
        <delete-popup/>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus"
import EditIcon from "@/Components/Web/Icons/Edit"
import DeleteIcon from "@/Components/Web/Icons/Delete"
import NewCompanyPopup from "@/Components/Web/Popup/NewCompany"
import EditCompanyPopup from "@/Components/Web/Popup/EditCompany"
import DeletePopup from "@/Components/Web/Popup/Delete"

export default {
    components: {
        EditIcon,
        DeleteIcon,
        NewCompanyPopup,
        EditCompanyPopup,
        DeletePopup
    },

    props: {
        companies: {
            type: Array
        }
    },

    methods: {
        handleShowEditCompany(company) {
            emitter.emit('showEditCompanyPopup', company)
        },

        handleShowDeletePopup(route) {
            emitter.emit('showDeletePopup', route)
        },

        handleShowNewCompany() {
            emitter.emit('showNewCompanyPopup')
        }
    }
}
</script>