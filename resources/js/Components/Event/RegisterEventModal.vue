<template>
    <div>
        <c-dialog-modal
            :show="showModal"
            :closeable="true"
            @close="toggleModal">
            <template v-slot:title>
                <div class="d-flex align-items-center w-100">
                    <div class="modal-title">
                        {{ item.title }}
                    </div>

                    <div class="ml-auto">
                        <c-button
                            class="btn btn-link btn-close mr-1 p-0"
                            @click="toggleModal"
                        >
                            <i class="pe-7s-close"></i>
                        </c-button>
                    </div>
                </div>
            </template>
            <template v-slot:content>
                <general-error :message="form.error"></general-error>
                <general-success :message="form.success"></general-success>
                <span class="d-flex">
                    {{ item.start_date }}
                </span>
                <span class="d-flex">
                    {{ __('Sure Register Event?') }}
                </span>
            </template>
            <template v-slot:footer class="center-block">
                <c-button
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing" v-on:click="toggleModal()"
                    class="btn btn-danger font-weight-bold">
                    {{ __('No') }}
                </c-button>
                <form @submit.prevent="registerEvent">
                    <c-button
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="btn btn-success font-weight-bold">
                        {{ __('Yes') }}
                    </c-button>
                </form>
            </template>
        </c-dialog-modal>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus";
import ActionMessage from "@/Jetstream/ActionMessage";
import GeneralError from "@/Components/GeneralError";
import GeneralSuccess from "@/Components/Event/GeneralSuccess";
import CDialogModal from "@/CoreUi/components/DialogModal";
import CButton from "@/CoreUi/components/Button";
import NProgress from 'nprogress'

export default {
    components: {
        GeneralSuccess,
        GeneralError,
        ActionMessage,
        CButton,
        CDialogModal
    },
    data() {
        return {
            showModal: false,
            item: {},
            form: this.$inertia.form({
                id: ''
            }),
            callbackFunction: Function
        }
    },
    watch: {
        'showModal'() {
            if (!this.showModal) {
                this.resetModalData()
            }
        }
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal
        },
        resetModalData() {
            this.item = {}
            this.form.processing = false;
            this.form.error = ''
        },
        registerEvent() {
            NProgress.start()
            this.form.processing = true;
            this.form.error = ''
            this.form.success = ''
            this.form.id = this.item.id
            axios.post(this.route('event.register', this.form.id)).then(response => {
                if (response.data) {
                    this.form.success = response.data.message
                    this.showModal = false
                    if (this.callbackFunction) {
                        this.callbackFunction(response.data.data)
                    }
                    emitter.emit('eventInfoModal', {
                        item: response.data.data.event,
                        isCreate: true
                    })
                }
                this.form.processing = false;
                NProgress.done()
            }).catch((error) => {
                this.form.processing = false;
                if (error.response.data) {
                    this.form.error = error.response.data.message
                }
                NProgress.done()
                NProgress.remove()
            })
        }
    },
    mounted() {
        emitter.on('showEventRegisterModal', (callbackData) => {
            this.showModal = true
            this.item = callbackData.item
            this.callbackFunction = callbackData.callbackFunction
        })
    }
}
</script>
