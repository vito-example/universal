<template>
    <landing>
        <template v-slot:main>
            <breadcrumb
                    :items="breadcrumb"
                    :active="item.title"
            />

            <div class="trainings-single container margin-top-48">
                <img :src="item.profile_image" v-if="item.profile_image" class="trainings-single__cover border-radius-10" alt="">

                <div class="trainings-single__content">
                    <div class="trainings-single__left margin-top-44">
                        <inertia-link :href="item.register_url" class="button button--primary button--shadow button--border text-center width-full hide-md-down">{{__('რეგისტრაცია')}}</inertia-link>

                        <hr>

                        <template v-if="item.can_request">
                            <inertia-link :href="item.request_url" class="button button--primary button--shadow button--border text-center width-full">{{__('მოთხოვნა')}}</inertia-link>

                            <hr>
                        </template>

                        <div class="trainings-single__labels flex flex-wrap gap-12">
                            <div
                                    v-for="(item,key) in item.sessions"
                                    v-if="item.sessions.length"
                                    class="flex space-between width-full"
                            >
                                <date-label
                                        v-if="item.can_register"
                                        :label="item.start_time"
                                        class="inline-flex items-center padding-y-8"
                                />

                                <time-label
                                        v-if="item.can_register"
                                        :label="item.start_time_hour"
                                        class="inline-flex items-center margin-left-12 padding-y-8"
                                />
                            </div>

                            <price-label
                                    v-if="item.price && !item.can_request"
                                    :label="`${__('ფასი')}: ${item.price} ₾`"
                                    class="inline-flex items-center padding-y-8"
                            />

                            <place-label
                                    v-if="item.place && !item.can_request"
                                    :label="item.place"
                                    class="inline-flex items-center padding-y-8"
                            />

                            <contact-label
                                    v-if="item.phone"
                                    :label="item.phone"
                                    class="inline-flex items-center padding-y-8"
                            />
                        </div>

                        <hr v-if="(item.price && !item.can_request) || (item.place && !item.can_request) || item.phone">

                        <button
                            v-if="item.syllabus"
                            type="button"
                            id="training-program"
                            class="button button--link color-fulvous font-size-sm text-decoration-none block"
                            @click="handleShowProgram(item)"
                        >
                            <div class="margin-right-10">
                                <program-icon width="32" height="24"/>
                            </div>
                            {{__('იხილეთ პროგრამა')}}
                        </button>

                        <hr class="margin-top-18" v-if="registerSessions.length && item.form === 200">

                        <button
                            v-if="registerSessions.length && item.form === 200"
                            type="button"
                            class="button button--secondary text-center width-full padding-y-12 padding-x-0 border-radius-12"
                            @click="onShowTrainingLinks"
                        >
                          {{__('ტრენინგის ლინკი')}}
                        </button>
                    </div>

                    <div class="trainings-single__right padding-left-134 padding-left-md-0">
                        <h2 class="font-weight-600 margin-top-40">
                          {{item.title}}
                        </h2>

                        <div class="margin-top-24">
                          {{__('თეგები')}}:
                            <template v-for="(direction,index) in drawDirections" v-if="directions.length">
                                <template v-if="direction.parents.length" v-for="(parent,index) in direction.parents">
                                        <inertia-link :href="item.form === 100 ? direction.offlineRoute : direction.onlineRoute"  class="button button--link color-fulvous text-decoration-none">
                                            {{parent.label}}
                                            <span>, </span>
                                        </inertia-link>
                                </template>
                                <inertia-link :href="item.form === 100 ? direction.offlineRoute : direction.onlineRoute"  class="button button--link color-fulvous text-decoration-none">
                                    {{direction.label}}
                                    <span v-if="index !== Object.keys(directions).length - 1">, </span>
                                </inertia-link>
                            </template>
                        </div>

                        <div class="trainings-single__description font-size-sm font-weight-300 line-height-default margin-top-24"
                             v-html="item.description" />

                        <gallery-section v-if="item.galleries.length" :gallery="gallery" />

                        <div class="trainings-single__lecturer" v-if="item.lecturers.length">
                            <h4 class="font-weight-600 margin-top-48">{{ __('ტრენერები') }}</h4>

                            <carousel
                                    class="trainers"
                                    :settings="carouselSettings"
                            >
                                <Slide
                                        v-for="(item, key) in item.lecturers"
                                        :key="key"
                                >
                                    <div class="flex space-between margin-top-32">
                                        <div class="trainings-single__lecturer-image">
                                            <img :src="item.profile_image" class="border-radius-10"
                                                 alt="">
                                        </div>

                                        <div class="trainings-single__lecturer-info padding-right-60">
                                            <h4 class="color-dark-green font-size-sm font-weight-600">{{item.full_name}}</h4>

                                            <p class="color-dark-green opacity-60 font-size-sm font-weight-400 line-height-default margin-top-16"
                                               v-html="item.description">
                                            </p>


                                            <a class="button button--link color-dark-green hover-color-hunter-green hover-right-left-animation text-decoration-none flex items-center margin-top-26"
                                               @click="handleShowTrainer(item.show_url)"
                                            >
                                                <div class="button__icon line-height-0 padding-right-15">
                                                    <arrow-icon
                                                            :width="8"
                                                            :height="14"
                                                    />
                                                </div>

                                                {{ __('მეტის ნახვა')}}
                                            </a>
                                        </div>
                                    </div>
                                </Slide>

                                <template #addons>
                                    <navigation />
                                </template>
                            </carousel>
                        </div>

                        <div class="trainings-single__reviews">
                            <trainings-review
                                :event="item"
                                :reviews="reviews"
                            />
                        </div>

                        <div v-if="similarEvents.length">
                            <h4 class="font-weight-600 margin-top-48 margin-bottom-24">{{__('მსგავსი ტრენინგები')}}</h4>

                            <div class="similar-carousel">
                                <carousel
                                        class="similar-trainings"
                                        :settings="trainingCarouselSettings"
                                >
                                    <Slide
                                            v-for="(item, key) in similarEvents"
                                            :key="key"
                                    >
                                        <training-item
                                                :training="item"
                                                type="offline"
                                        />
                                    </Slide>

                                    <template #addons>
                                        <navigation />
                                    </template>
                                </carousel>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <drawer
                :title="drawer.title"
                width="708px"
            >
                <template v-slot:body>
                    <a v-if="item.files.length" v-for="(el,key) in item.files" :href="el.file" :key="key" target="_blank" class="color-fulvous font-size-sm text-decoration-none flex items-center margin-bottom-10">
                        <div>
                            <download-icon width="32" height="24"/>
                        </div>
                        {{__('პროგრამის ჩამოტვირთვა')}}
                    </a>
                    <p class="font-weight-300 line-height-default" v-html="drawer.description">

                    </p>
                </template>
            </drawer>

            <training-drawer />
            <trainer-drawer />
            <online-training-links width="728px" />
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import DateLabel from "@/Components/Label/DateLabel"
import TimeLabel from "@/Components/Label/TimeLabel"
import PriceLabel from "@/Components/Label/PriceLabel"
import PlaceLabel from "@/Components/Label/PlaceLabel"
import ContactLabel from "@/Components/Label/ContactLabel"
import CalendarIcon from "@/Components/Web/Icons/Calendar"
import ProgramIcon from "@/Components/Web/Icons/ProgramIcon"
import CashIcon from "@/Components/Web/Icons/Cash"
import DownloadIcon from "@/Components/Web/Icons/Download"
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import Drawer from "@/Components/Web/Drawer/Drawer"
import OnlineTrainingLinks from "@/Components/Web/Popup/OnlineTrainingLinks"
import TrainingsReview from "@/Components/Sections/Review/Review"
import TrainingDrawer from "@/Components/Training/TrainingDrawer"
import emitter from "@/Plugins/bus"
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button"
import GallerySection from "@/Components/Sections/Gallery"
import { Carousel, Navigation, Slide } from "vue3-carousel"
import ArrowIcon from "@/Components/Web/Icons/Arrow"
import TrainerDrawer from "@/Components/Trainer/TrainerDrawer"
import {getData} from "@/base/mixins/getData"
import {responseParse} from "@/base/mixins/responseParse"
import TrainingItem from "@/Components/Training/TrainingItem"

export default {
    components: {
      Button,
        Landing,
        Breadcrumb,
        DateLabel,
        TimeLabel,
        PriceLabel,
        PlaceLabel,
        ContactLabel,
        CalendarIcon,
        CashIcon,
        Drawer,
        ProgramIcon,
        DownloadIcon,
        OnlineTrainingLinks,
        TrainingsReview,
        TrainingDrawer,
        GallerySection,
        Carousel,
        Slide,
        Navigation,
        ArrowIcon,
        TrainerDrawer,
        TrainingItem
    },
    props: {
        item: {
            type: Array
        },
        similarEvents: {
            type: Array
        },
        registerSessions: {
            type: Array
        },
        directions: {
            type: Array
        },
        reviews: {
          type: Array
        }
    },
    data() {
        return {
            carouselSettings: {
                itemsToShow: 1,
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
                        itemsToShow: 1
                    },
                },
            },
            trainingCarouselSettings: {
                itemsToShow: 2,
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
                        itemsToShow: 2
                    },
                },
            },
            drawer: {
                title: '',
                description: ''
            },
            drawDirections: [],
            breadcrumb: [
                {
                    label: 'ტრენინგები',
                    route: 'trainings.index'
                }
            ]
        }
    },
    computed: {
        gallery () {
            return this.item?.galleries.map(item => {
                item = [{ value: item }]
                return item
            })
        }
    },

    created() {
        let directions = [];
        let ids = [];
        if (this.directions.length) {
            this.directions.forEach((el,index) => {
                const parents = [];
                if (el.parents) {
                    for (const [key, value] of Object.entries(el.parents)) {
                        if (!ids.includes(value.id)) {
                            parents.push(value);
                            ids.push(value.id);
                        }
                    }
                }
                directions.push({
                    ...el,
                    parents: parents
                })
            })
        }
        this.drawDirections = directions;

        console.log(this.gallery)
    },
    methods: {
        handleShowProgram(training) {
            emitter.emit('showTrainigDrawer', training)
        },

      onShowTrainingLinks () {
        emitter.emit('showOnlineTrainingLinks',this.registerSessions)
      },
        async handleShowTrainer(showUrl) {
            this.loading = true;

            await getData({
                method: 'GET',
                url: showUrl,
            }).then(response => {
                // Parse response notification.
                responseParse(response, false);

                if (response.status === 200) {
                    // Response data.
                    let data = response.data;

                    emitter.emit('showTrainerDrawer', data.lecturer)
                }
                this.loading = false
            })
        }
    }
}
</script>
