<template>
    <div>
        <c-dialog-modal
            class="beta-modal fade"
            :show="showModal"
            :closeable="true"
            @close="toggleModal"
        >
            <template v-slot:title>
                <c-button v-on:click="toggleModal()" class="btn btn-secondary p-0 ml-auto">
                    <i class="pe-7s-close"></i>
                </c-button>
            </template>
            <template v-slot:content>
                <p v-html="getContent"></p>
            </template>
        </c-dialog-modal>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus";
import CDialogModal from "@/CoreUi/components/DialogModal";
import CButton from "@/CoreUi/components/Button";

export default {
    components: {
        CDialogModal,
        CButton
    },
    data() {
        return {
            showModal: false
        }
    },
    computed: {
        getContent() {
            return this.$page.props.betaModal.fields.description.value
        }
    },
    methods: {
        toggleModal() {
            this.showModal = !this.showModal
        }
    },
    mounted() {
        emitter.on('betaModalShow', () => {
            this.showModal = true
        })
    }
}
</script>
