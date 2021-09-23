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
import HeroItem from "@/Components/Home/Hero/HeroItem"

export default {
    components: {
        HeroItem,
    },

    props: {
        item: Array
    },

    computed: {
        heroData() {
            return this.item?.fields?.fields?.value
        },
    },
}
</script>
