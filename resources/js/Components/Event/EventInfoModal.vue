<template>
    <div>
        <c-dialog-modal
            class="fade"
            :show="showModal"
            :closeable="true"
            @close="toggleModal">
            <template v-slot:title>
                {{ item.title }}
            </template>
            <template v-slot:content>
                <general-success :message="form.success"></general-success>
                <add-to-calendar-event
                    :item="item"
                    :calendar-item-data="getCalendarData"
                ></add-to-calendar-event>
            </template>
            <template v-slot:footer class="center-block">
                <c-button v-on:click="toggleModal()" class="btn btn-secondary">{{ __('Close') }}</c-button>
            </template>
        </c-dialog-modal>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus";
import ActionMessage from "@/Jetstream/ActionMessage";
import GeneralError from "@/Components/GeneralError";
import GeneralSuccess from "@/Components/Event/GeneralSuccess";
import AddToCalendarEvent from "@/Components/Event/AddToCalendarEvent";
import CDialogModal from "@/CoreUi/components/DialogModal";
import CButton from "@/CoreUi/components/Button";

export default {
    components: {AddToCalendarEvent, GeneralSuccess, GeneralError, ActionMessage, CDialogModal, CButton},
    data() {
        return {
            showModal: false,
            item: {},
            calendars: {},
            form: {}
        }
    },
    watch: {
        'showModal'() {
            if (!this.showModal) {
                this.resetModalData()
            }
        }
    },
    computed: {
        getCalendarData() {
            if (!this.item) {
                return {}
            }
            return this.item.calendar_data
        }
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal
        },
        resetModalData() {
            this.item = {}
        },
    },
    mounted() {
        emitter.on('eventInfoModal', (emitterData) => {
            this.showModal = true
            this.item = emitterData.item
            if (emitterData.isCreate) {
                this.form.success = this.__('User register in event successfully')
            }
        })
    }
}
</script>
