<template v-show="item">
    <div class="home__section about container margin-top-117 margin-top-sm-96">
        <div class="row">
            <div class="col-6 col-lg-6 col-sm-12 padding-right-98 padding-right-sm-10 order-sm-1">
                <div class="home__section-image margin-top-6 margin-top-sm-34 border-radius-10">
                    <lazy-image
                            :src="item.fields.banner_image.value"
                            :alt="item.fields.title.value"
                            :show-placeholder="true"
                            class="border-radius-10"
                    />
                </div>
            </div>

            <div class="col-6 col-lg-6 col-sm-12 padding-left-20 padding-left-sm-10">
                <h2 class="color-dark-green font-weight-600 line-height-default">{{item.fields.title.value}}</h2>
                <div
                        class="color-dark-green line-height-22 padding-top-20"
                        v-html="item.fields.description.value"
                />

                <inertia-link
                        :href="route('about.index')"
                        class="button button--link font-size-xs color-black text-decoration-none flex items-center margin-top-34"
                >
                    <div class="button__icon line-height-0 padding-right-15">
                        <arrow-icon
                                :width="8"
                                :height="14"
                        />
                    </div>

                    {{__('მეტის წაკითხვა')}}
                </inertia-link>
            </div>
        </div>
    </div>

</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"
import ArrowIcon from "@/Components/Web/Icons/Arrow"

export default {
    components: {
        LazyImage,
        ArrowIcon
    },

    props: {
        item: Array
    },
}
</script>
