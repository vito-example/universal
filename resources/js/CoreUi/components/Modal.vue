<template>
    <transition name="fade">
        <div class="modal fade show" aria-modal="true"  role="dialog" tabindex="-1" v-if="show" style="display: block;" :class="maxWidthClass">
            <slot></slot>
        </div>
    </transition>
</template>

<script>
import { onMounted, onUnmounted } from "vue";

export default {
        emits: ['close'],

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

        watch: {
            show: {
                immediate: true,
                handler: (show) => {
                    if (show) {
                        document.body.style.overflow = 'hidden'
                    } else {
                        document.body.style.overflow = null
                    }
                }
            }
        },

        setup(props, {emit}) {
            const close = () => {
                if (props.closeable) {
                    emit('close')
                }
            }

            const closeOnEscape = (e) => {
                if (e.key === 'Escape' && props.show) {
                    close()
                }
            }

            onMounted(() => document.addEventListener('keydown', closeOnEscape))
            onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

            return {
                close
            }
        },

        computed: {
            maxWidthClass() {
                return {
                    'sm': 'cd-example-modal-sm',
                    'md': 'cd-example-modal-md',
                    'lg': 'cd-example-modal-lg'
                }[this.maxWidth]
            }
        }
    }
</script>
