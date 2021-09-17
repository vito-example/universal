<template>
    <slide>
        <div class="container grid grid-2 grid-sm-1">
            <div class="hero__content padding-right-80 padding-right-md-0">
                <h2
                        class="color-dark-green font-size-xxl font-weight-600 line-height-58"
                        data-aos="fade-left"
                        data-aos-delay="200"
                >
                    {{ title }}
                </h2>
                <div
                        class="hero__text color-dark-green line-height-22 padding-top-26"
                        v-html="description"
                        data-aos="fade-down"
                        data-aos-delay="700"
                />

                <inertia-link
                        :href="buttonLink"
                        class="button button--primary button--shadow button--border margin-top-38"
                        data-aos="fade-down"
                        data-aos-delay="1200"
                >
                    {{ buttonText }}
                </inertia-link>
            </div>

            <div
                    class="hero__image flex justify-end"
                    data-aos="fade-right"
                    data-aos-delay="200"
            >
                <lazy-image :src="image" />
            </div>
        </div>
    </slide>
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
        title () {
            return this.getValueByFields('title')
        },

        description () {
            return this.getValueByFields('description')
        },

        buttonText () {
            return this.getValueByFields('button_text')
        },

        buttonLink () {
            return this.getValueByFields('button_link')
        },

        image () {
            return this.getValueByFields('image')
        }
    },

    methods: {
        getValueByFields(key) {
            return this.slide.filter((item) => item.name === key)?.[0]?.value
        }
    }
}
</script>