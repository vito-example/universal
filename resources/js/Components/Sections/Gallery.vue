<template>
    <div class="gallery">
        <h4 class="font-weight-600 margin-top-48">ფოტო გალერეა</h4>

        <div class="margin-top-32">
            <Carousel class="gallery-carousel" :settings="carouselSettings">
                <Slide v-for="(slide, index) in gallery" :key="index" class="cursor-pointer" @click="onShowZoom(index)">
                    <img :src="slide[0].value" class="about-gallery-thumb border-radius-10" alt="">
                </Slide>

                <template #addons>
                    <Navigation/>
                </template>
            </Carousel>
        </div>

        <gallery-zoom :gallery="gallery"/>
    </div>
</template>

<script>
import {Carousel, Slide, Pagination, Navigation} from "vue3-carousel"
import GalleryZoom from "@/Components/Sections/GalleryZoom"
import emitter from "@/Plugins/bus"

export default {
    components: {
        Carousel,
        Slide,
        Navigation,
        GalleryZoom
    },

    props: {
        gallery: {
            type: Array
        },

        imageKey: {
            type: String,
            default: 'value'
        }
    },

    data () {
        return {
            carouselSettings: {
                itemsToShow: 4,
                snapAlign: 'start',
                mouseDrag: false,
                breakpoints: {
                    0: {
                        itemsToShow: 1.5,
                        snapAlign: 'start',
                    },

                    680: {
                        itemsToShow: 4
                    },
                },
            },
        }
    },

    methods: {
        onShowZoom(index) {
            emitter.emit('showZoomGallery', index)
        }
    }
}
</script>