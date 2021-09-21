<template>
    <landing class="home">
        <template v-slot:main>
            <template v-for="(item,key) in page" v-if="page.length">
                <template v-if="item.key === 'slider'">
                    <hero-section :item="item"/>
                </template>
                <template v-if="item.key === 'services'">
                    <services-section :page="item" :items="services" />
                </template>
                <template v-if="item.key === 'about'">
                    <about-section :item="item"/>
                </template>
                <template v-if="item.key === 'statistic'">
                    <statistic-section :item="item"/>
                </template>
                <template v-if="item.key === 'projects'">
                    <projects-section :page="item" :items="projects" />
                </template>
                <template v-if="item.key === 'galleries'">
                    <gallery-section :item="item" />
                </template>
                <template v-if="item.key === 'blogs'">
                    <news-section :page="item" :items="blogs" />
                </template>
                <template v-if="item.key === 'teams'">
                    <team-section :page="item" :items="teams" />
                </template>
            </template>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import HeroSection from "../../../Components/Home/HeroSection";
import AboutSection from "../../../Components/Home/AboutSection";
import StatisticSection from "../../../Components/Home/StatisticSection";
import ProjectsSection from "../../../Components/Home/ProjectsSection";
import ServicesSection from "../../../Components/Home/ServicesSection";
import GallerySection from "../../../Components/Home/GallerySection";
import NewsSection from "../../../Components/Home/NewsSection";
import TeamSection from "../../../Components/Home/TeamSection";
import $ from 'jquery';

export default {
    components: {
        Landing,
        HeroSection,
        AboutSection,
        StatisticSection,
        ProjectsSection,
        GallerySection,
        NewsSection,
        TeamSection,
        ServicesSection
    },
    props: {
        page: {
            type: Array
        },
        projects: {
            type: Array
        },
        blogs: {
            type: Array
        },
        teams: {
            type: Array
        },
        services: {
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
