<template>
    <landing class="home">
        <template v-slot:main>
            <div class="content margin-top-50 margin-top-md-10">
                <template v-for="(item,key) in page" v-if="page.length">
                    <template v-if="item.key === 'slider'">
                        <hero-section :item="item"/>
                    </template>
                    <template v-if="item.key === 'companies'">
                        <companies-section :item="item"/>
                    </template>
                    <template v-else-if="item.key === 'trainings'">
                        <training-section
                                :title="__('ტრენინგები')"
                                :all-title="__('ყველა ტრენინგი')"
                                :all-href="route('trainings.index')"
                                :items="offlineEvents"
                                type="offline"
                        />
                    </template>
                    <template v-else-if="item.key === 'online_trainings'">
                        <training-section
                                :title="__('ონლაინ ტრენინგები')"
                                :all-title="__('ყველა ონლაინ ტრენინგი')"
                                :all-href="route('trainings.online')"
                                :items="onlineEvents"
                                type="online"
                                class="margin-top-168 margin-top-sm-90"
                        />
                    </template>
                    <template v-else-if="item.key === 'news'">
                        <news-section
                                :items="blogs"
                                :page="item"
                        />
                    </template>
                    <template v-else-if="item.key === 'about'">
                        <about-section :item="item" />
                    </template>
                    <template v-else-if="item.key === 'trainers'">
                        <trainers-section :items="lecturers" :page="item" />
                    </template>
                    <template v-else-if="item.key === 'statistic'">
                        <statistic-section :item="item" />
                    </template>
                </template>
                <div class="home__section container margin-top-137 margin-top-sm-10" v-if="reviews?.length">
                    <h2 class="color-dark-green font-weight-600 text-center-sm-up">მომხმარებლები ჩვენს შესახებ</h2>
                    <p class="color-dark-green opacity-60 font-weight-300 text-center-sm-up line-height-24 padding-top-28">
                        ჩვენ გვყავს 2000+ წარმატებული მომხმარებელი რომლებიც<br>
                        ბედნიერები ავითარებენ მათ აგრო ბიზნესებს ჩვენი ტრენინგების შემდეგ
                    </p>

                    <div class="row margin-top-39">
                        <div
                                v-for="(review, index) in reviews"
                                :key="index"
                                class="col-3 col-lg-3 col-md-6 col-sm-12 margin-bottom-sm-39"
                        >
                            <star-rating
                                    inactive-color="#D2D2D2"
                                    active-color="#0A2B12"
                                    :star-size="14"
                                    :show-rating="false"
                                    :read-only="true"
                                    :padding="10"
                                    v-model:rating="review.value"
                            />
                            <h4 class="font-weight-600 padding-top-8">{{ reviewRateName(review) }}</h4>
                            <h6 class="color-dark-green font-weight-600 padding-top-12">{{ review.user.name }} {{ review.user.surname }}</h6>

                            <p class="color-dark-green opacity-60 font-weight-300 height-116 height-sm-auto line-height-22 border-bottom-1 padding-top-22 padding-bottom-26">
                                {{ stringLimit(review.content, 80) }}
                            </p>

                            <button class="button button--link font-size-xs color-dark-green hover-color-apple-green text-decoration-none flex items-center margin-y-18">
                                <div class="button__icon line-height-0 padding-right-10">
                                    <favourite-icon
                                            width="16"
                                            height="20"
                                    />
                                </div>

                                {{ stringLimit(review.model.title, 36) }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>
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
