<template>
    <div class="drawer">
        <div
                class="drawer__inner animate__animated animate__faster"
                :class="drawerClasses"
                :style="{'width': width}"
                ref="drawer"
        >
            <div class="drawer__header">
                <div class="font-size-xl font-weight-600 margin-top-14">{{ title }}</div>
                <div v-if="subTitle" class="font-size-md font-weight-300 margin-top-22">{{ subTitle }}</div>

                <button
                        class="drawer__close button button--link color-black text-decoration-none"
                        @click="handleClose"
                >
                    <close-icon width="14" height="14"/>
                </button>
            </div>
            <div class="drawer__body">
                <perfect-scrollbar>
                    <slot name="body"/>
                </perfect-scrollbar>
            </div>
        </div>
        <div
                class="drawer__overlay"
                @click="handleClose"
        ></div>
    </div>
</template>

<script>
import { PerfectScrollbar } from "vue3-perfect-scrollbar"
import CloseIcon from "@/Components/Web/Icons/Close"

export default {
    components: {
        PerfectScrollbar,
        CloseIcon
    },

    props: {
        title: {
            type: String
        },
        subTitle: {
            type: String
        },
        width: {
            type: String
        }
    },

    data () {
        return {
            animate: 'animate__fadeInRight',
        }
    },

    computed: {
        drawerClasses () {
            return this.animate
        }
    },

    methods: {
        handleClose() {
            this.animate = 'animate__fadeOutRight'

            this.$refs.drawer.addEventListener('animationend', () => {
                this.$parent.visible = false
            })
        }
    }
}
</script>