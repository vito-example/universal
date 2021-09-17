<template>
    <div class="gallery-zoom" v-if="visible">
        <div class="gallery-zoom__content">
            <Carousel :items-to-show="1">
                <Slide v-for="slide in gallery" :key="slide">
                    <img :src="slide[0].value" class="border-radius-10" alt="">
                </Slide>

                <template #addons>
                    <Navigation/>
                </template>
            </Carousel>
        </div>

        <div class="gallery-zoom__overlay" @click="onClose"></div>
    </div>
</template>

<script>
import {Carousel, Navigation, Slide} from "vue3-carousel"
import emitter from "@/Plugins/bus"

export default {
    components: {
        Carousel,
        Slide,
        Navigation
    },

    props: {
        gallery: {
            type: Array
        }
    },

    data() {
        return {
            visible: false,
            initialSlide: 0
        }
    },

    methods: {
        onClose() {
            this.visible = false
        }
    },

    mounted() {
        emitter.on('showZoomGallery', (data) => {
            this.visible = true
        })
    }
}
</script>