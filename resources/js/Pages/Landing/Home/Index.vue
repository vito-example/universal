<template>
    <landing class="home">
        <template v-slot:main>
            <h1>12345</h1>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import {Carousel, Slide, Pagination, Navigation} from 'vue3-carousel';
import HeroSection from "../../../Components/Home/HeroSection";
import CompaniesSection from "../../../Components/Home/CompaniesSection";
import TrainingSection from "../../../Components/Home/TrainingSection";
import NewsSection from "../../../Components/Home/NewsSection";
import AboutSection from "../../../Components/Home/AboutSection";
import TrainersSection from "../../../Components/Home/TrainersSection";
import StatisticSection from "../../../Components/Home/StatisticSection";
import FavouriteIcon from "@/Components/Web/Icons/Favourite";
import {rateNames} from "@/Helpers/Rating";
import StarRating from "@/Components/Sections/Review/Rating/star-rating"

export default {
    components: {
        Landing,
        Carousel,
        Slide,
        Pagination,
        Navigation,
        HeroSection,
        TrainingSection,
        NewsSection,
        AboutSection,
        TrainersSection,
        StatisticSection,
        CompaniesSection,
        FavouriteIcon,
        StarRating
    },
    props: {
        page: {
            type: Array
        },
        onlineEvents: {
            type: Array
        },
        offlineEvents: {
            type: Array
        },
        blogs: {
            type: Array
        },
        lecturers: {
            type: Array
        },
        reviews: {
            type: Array
        }
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

        reviewRateName (review) {
            const value = Number(review.value)

            return this.__(rateNames[value.toFixed(0)])
        },

        stringLimit (string, limit = 100) {
            if (string) {
                return string.length > limit ? `${string.substring(0, limit)} ...` : string;
            }
            return '';
        }
    }
}
</script>
