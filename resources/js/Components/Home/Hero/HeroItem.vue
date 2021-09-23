<template>
    <div class="slide">
        <img class="bg" :src="image" alt="" />
        <div class="showcase_overlay">
            <div class="flex center hero_content wrapper">
                <div class="text_bg bold">{{backgroundTitle}}</div>
                <div class="ab_title bold">{{title}}</div>
                <div class="title bold" v-html="description">
                </div>
                <div class="sub_title dc" style="max-width: 609px" v-html="content">
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { Slide } from "vue3-carousel"
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        Slide,
        LazyImage
    },

    props: {
        slide: {
            type: Object
        },

        key: {
            type: Number
        }
    },

    computed: {
        backgroundTitle () {
            return this.getValueByFields('background_title')
        },

        title () {
            return this.getValueByFields('title')
        },

        description () {
            return this.getValueByFields('description')
        },

        content () {
            return this.getValueByFields('content')
        },

        image () {
            return this.getValueByFields('image')
        }
    },

    methods: {
        getValueByFields(key) {
            return this.slide.filter((item) => item.name === key)?.[0]?.value
        }
    },
}
</script>
