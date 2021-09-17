<template>
    <div v-if="showButton">
        <c-button
            v-on:click="showRegisterEventModal"
            class="btn btn-success btn-pill text-uppercase font-weight-bold mr-3 px-2"
        >
            {{ __('Register event') }}
        </c-button>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus";
import CButton from "@/CoreUi/components/Button";

export default {
    components: {
        CButton
    },
    props: {
        event: {
            type: Object
        },
        canRegister: {
            type: Boolean
        }
    },
    computed: {
        showButton () {
            return this.canRegister && this.canSubmitButton
        }
    },
    data () {
        return {
            showDialog: false,
            canSubmitButton: true
        }
    },
    methods: {
        registeredEvent (eventItem) {
            this.canSubmitButton = false
        },
        showRegisterEventModal () {
            if (!this.isAuth()) {
                window.location.href = route('login')
                return
            }
            this.showDialog = true
            emitter.emit('showEventRegisterModal', {
                item: this.event,
                callbackFunction: this.registeredEvent
            })
        }
    }
}
</script>
