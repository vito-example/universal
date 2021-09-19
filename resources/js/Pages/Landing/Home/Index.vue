<template>
    <landing class="home">
        <template v-slot:main>
            <template v-for="(item,key) in page" v-if="page.length">
                <template v-if="item.key === 'slider'">
                    <hero-section :item="item"/>
                </template>
            </template>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import HeroSection from "../../../Components/Home/HeroSection";
import $ from 'jquery';

export default {
    components: {
        Landing,
        HeroSection,
    },
    props: {
        page: {
            type: Array
        },
    },
    methods: {
        getValueByFields(fields, key) {
            let value = '';
            fields.forEach((item) => {
                if (!value && item.name === key) {
                    value = item.value
                }
            })
            return value
        },
        stringLimit (string, limit = 100) {
            if (string) {
                return string.length > limit ? `${string.substring(0, limit)} ...` : string;
            }
            return '';
        }
    },
    mounted() {
        $(".hero_slider").not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            draggable: true,
            arrows: true,
            prevArrow: "#prev_heroslide",
            nextArrow: "#next_heroslide",
            dots: true,
            fade: true,
            speed: 900,
            infinite: true,
            cssEase: "cubic-bezier(0.7, 0, 0.3, 1)",
            touchThreshold: 100,
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnHover: false,
        });
    }
}
</script>
