<template>
    <div class="home__section container margin-top-120 margin-top-xs-30 padding-x-sm-0">
        <div class="trainers-container">
            <div class="padding-right-12 padding-x-sm-20">
                <h2 class="color-dark-green font-weight-600 line-height-43">{{ page.fields.title.value }}</h2>
                <div
                        class="color-dark-green line-height-22 padding-top-30 padding-bottom-sm-30"
                        v-html="page.fields.description.value"
                />
                <inertia-link
                        :href="route('trainers.index')"
                        class="button button--link color-black hover-color-hunter-green hover-right-left-animation text-decoration-none flex items-center hide-sm-down margin-top-50"
                >
                    <div class="button__icon line-height-0 padding-right-15">
                        <arrow-icon
                                :width="8"
                                :height="14"
                        />
                    </div>

                    {{ __('ყველა ტრენერი') }}
                </inertia-link>
            </div>

            <div>
                <div class="trainers-carousel">
                    <carousel
                            class="trainers"
                            :settings="carouselSettings"
                    >
                        <Slide
                                v-for="(item, key) in items"
                                :key="key"
                        >
                            <trainer-item :trainer="item" />
                        </Slide>

                        <template #addons>
                            <div class="container carousel__navigation flex items-center space-between margin-top-sm-40">
                                <div class="carousel__navigation-more">
                                    <inertia-link
                                            :href="route('trainers.index')"
                                            class="button button--link color-black text-decoration-none flex items-center"
                                    >
                                        <div class="button__icon line-height-0 padding-right-15">
                                            <arrow-icon
                                                    :width="8"
                                                    :height="14"
                                            />
                                        </div>

                                        {{ __('ყველა ტრენერი') }}
                                    </inertia-link>
                                </div>

                                <div>
                                    <navigation />
                                </div>
                            </div>
                        </template>
                    </carousel>
                </div>
            </div>
        </div>

        <trainer-drawer />
    </div>

</template>

<script>
import { Carousel, Navigation, Slide } from "vue3-carousel"
import TrainerItem from "@/Components/Trainer/TrainerItem"
import ArrowIcon from "@/Components/Web/Icons/Arrow"
import TrainerDrawer from "@/Components/Trainer/TrainerDrawer"

export default {
    components: {
        Carousel,
        Slide,
        Navigation,
        TrainerItem,
        ArrowIcon,
        TrainerDrawer
    },

    props: {
        page: Array,
        items: Array
    },

    data () {
        return {
            carouselSettings: {
                itemsToShow: 3,
                snapAlign: 'start',
                mouseDrag: false,
                breakpoints: {
                    0: {
                        itemsToShow: 1.22,
                        snapAlign: 'start',
                    },

                    580: {
                        itemsToShow: 2.22,
                        snapAlign: 'start',
                    },

                    992: {
                        itemsToShow: 3
                    },
                },
            },

            trainerShow: {
                full_name : '',
                description: '',
            }
        }
    }
}
</script>
