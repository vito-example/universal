<template v-show="item">
    <carousel
            class="hero"
            :items-to-show="1"
    >
      <hero-item
              v-for="(slide, index) in heroData"
              :key="index"
              :slide="slide"
      />

      <template #addons>
        <div
                v-if="hasNavigation"
                class="container carousel__navigation"
                data-aos="fade"
                data-aos-delay="1400"
        >
            <navigation />
        </div>
      </template>
    </carousel>
</template>

<script>
import { Carousel, Navigation } from "vue3-carousel"
import HeroItem from "@/Components/Home/Hero/HeroItem"

export default {
    components: {
        Carousel,
        Navigation,
        HeroItem
    },

    props: {
        item: Array
    },

    computed: {
        heroData () {
            return this.item?.fields?.fields?.value
        },

        hasNavigation () {
            return this.heroData?.length > 1
        }
    }
}
</script>
