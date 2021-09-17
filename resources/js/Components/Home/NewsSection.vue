<template>
    <div class="home__section container margin-top-183 margin-top-sm-90">
        <div class="row">
            <div class="col-6 col-lg-6 col-sm-12">
                <h2 class="color-dark-green font-size-xl font-weight-600 line-height-43 padding-right-30">
                    {{ page.fields.title.value }}
                </h2>
                <div
                        class="color-dark-green line-height-22 padding-top-26"
                        v-html="page.fields.description.value"
                />

                <inertia-link
                        :href="route('news.index')"
                        class="button button--primary button--shadow button--border margin-top-35 hide-md-down"
                >
                    {{__('ყველა სიახლე')}}
                </inertia-link>
            </div>

            <div class="col-6 col-lg-6 col-sm-12 margin-top-sm-38">
                <template v-if="mq.lgPlus">
                    <div class="news-carousel margin-top-sm-24">
                        <carousel
                                class="news"
                                :settings="carouselSettings"
                        >
                            <Slide
                                    v-for="(item, key) in items"
                                    :key="key"
                            >
                                <news-item :item="item" />
                            </Slide>

                            <template #addons>
                                <div
                                        class="container carousel__navigation"
                                >
                                    <navigation />
                                </div>
                            </template>
                        </carousel>
                    </div>
                </template>

                <template v-else>
                    <news-item
                            v-for="(item, key) in items"
                            :key="key"
                            :item="item"
                            class="margin-bottom-sm-50"
                    />
                </template>
            </div>
        </div>

        <div class="home__section-more">
            <hr class="margin-y-0" />
            <inertia-link
                    :href="allHref"
                    class="button button--link color-black text-decoration-none text-center block margin-top-32"
            >
                {{ __('ყველა სიახლე') }}
            </inertia-link>
        </div>
    </div>
</template>

<script>
import { Carousel, Slide, Navigation } from "vue3-carousel"
import NewsItem from "@/Components/News/NewsItem"

export default {
    components: {
        Carousel,
        Slide,
        Navigation,
        NewsItem
    },

    props: {
        page: Array,
        items: Array
    },

    inject: ["mq"],

    data () {
        return {
            carouselSettings: {
                itemsToShow: 2,
                snapAlign: 'start',
                mouseDrag: false
            }
        }
    }
}
</script>
