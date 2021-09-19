<template v-show="item">
    <section class="hero_section_container">
        <section class="hero_section hero_slider margin_bottom">
        <hero-item
            v-for="(slide, index) in heroData"
            :key="index"
            :slide="slide"
        />
        </section>
        <div class="arrows flex">
            <button id="prev_heroslide" class="flex center">
                <img src="/landing_resources/img/icons/slider/prev.png" alt="" />
            </button>
            <button id="next_heroslide" class="flex center">
                <img src="/landing_resources/img/icons/slider/next.png" alt="" />
            </button>
        </div>

    </section>
</template>

<script>
import {Carousel, Navigation} from "vue3-carousel"
import HeroItem from "@/Components/Home/Hero/HeroItem"
import Slick from 'vue-slick';

export default {
    components: {
        Navigation,
        HeroItem,
        Slick
    },

    props: {
        item: Array
    },

    computed: {
        heroData() {
            console.log(this.item?.fields?.fields?.value)
            return this.item?.fields?.fields?.value
        },

        hasNavigation() {
            return this.heroData?.length > 1
        }
    }
}
</script>
