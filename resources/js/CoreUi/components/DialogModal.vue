<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="modal-dialog modal-dialog-centered" role="document" v-click-away="onClickAway">
            <div class="modal-content">
                <div class="modal-header pt-1 pb-0 font-weight-bold">
                    <slot name="title">
                    </slot>
                </div>
                <div class="modal-body py-4">
                    <slot name="content">
                    </slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer">
                    </slot>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import Modal from './Modal'
    import { directive } from "vue3-click-away";

    export default {
        emits: ['close'],

        directives: {
            ClickAway: directive
        },

        components: {
            Modal,
        },

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: 'sm'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },

            onClickAway () {
                this.close()
            }
        }
    }
</script>
