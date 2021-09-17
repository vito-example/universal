<template>
    <div class="events-section mt-4">
        <div class="container">
            <div class="main_title pt-4">
                <a :href="route('event.index')">
                    <h3>{{ sectionTitle }}</h3>
                </a>
            </div>

            <carousel :items-to-show="2" :breakpoints="breakpoints">
                <template #addons>
                    <navigation />
                </template>

                <slide v-for="(item, index) in items" :key="index">
                    <card-event :item="item">
                        <template #imageHref="{ item }">
                            <a :href="item.show_url" class="no-underline hover:underline text-black float-left" >
                                <img alt="Placeholder" class="img-thumbnail" :src="item.profile_image_url">
                            </a>
                        </template>
                        <template #conferenceButton="{ item }">
                            <a :href="item.conference_url">
                                <c-button
                                    class="btn btn-info btn-pill text-uppercase font-weight-bold mr-3 px-2">
                                    {{ __('Open Conference') }}
                                </c-button>
                            </a>
                        </template>
                        <template #learnMoreButton="{ item }">
                            <a :href="item.show_url">
                                <c-button class="btn btn-warning btn-pill text-uppercase font-weight-bold mr-3 px-2">
                                    {{ __('Learn more') }}
                                </c-button>
                            </a>
                        </template>
                    </card-event>
                </slide>
            </carousel>
        </div><!-- End container -->
    </div>
</template>

<script>
import CardEvent from "@/Components/Event/CardEvent";
import {Carousel, Navigation, Slide} from "vue3-carousel";

export default {
    components: {
        CardEvent,
        Carousel,
        Slide,
        Navigation,
    },

    props: {
        items: {
            type: Array
        },

        sectionTitle: {
            type: String
        }
    },

    data () {
        return {
            breakpoints: {
                0: {
                    itemsToShow: 1
                },

                1024: {
                    itemsToShow: 2,
                    snapAlign: 'start',
                }
            }
        }
    }
}
</script>
