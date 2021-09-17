<template>
    <div class="card border-md-none">
        <div class="card__body padding-lg-20 padding-md-0">
            <inertia-link
                    :href="showUrl"
                    class="card__image"
                    :title="title"
            >
                <lazy-image
                        :src="image"
                        :show-placeholder="true"
                        :alt="title"
                />
            </inertia-link>

            <inertia-link
                    :href="showUrl"
                    class="text-decoration-none"
            >
                <h4 class="card__title">
                    {{ title }}
                </h4>
            </inertia-link>

            <div
                    class="card__text font-weight-400"
                    v-html="description"
            />

            <div class="flex flex-wrap gap-12 margin-top-29">
                <date-label :label="createdAt" />
                <price-label :label="`${__('ფასი')}: ${price} ₾`" />

                <online-label
                        v-if="isOnline"
                        :label="__('Online')"
                />
            </div>

            <inertia-link
                    :href="registerUrl"
                    class="button button--link color-black hover-color-hunter-green hover-right-left-animation text-decoration-none flex items-center margin-top-33"
            >
                <div class="button__icon line-height-0 padding-right-15">
                    <arrow-icon
                            :width="8"
                            :height="14"
                    />
                </div>

                {{__('რეგისტრაცია')}}
            </inertia-link>
        </div>
    </div>
</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"
import DateLabel from "@/Components/Label/DateLabel"
import PriceLabel from "@/Components/Label/PriceLabel"
import OnlineLabel from "@/Components/Label/OnlineLabel"
import ArrowIcon from "@/Components/Web/Icons/Arrow"

export default {
    components: {
        LazyImage,
        DateLabel,
        PriceLabel,
        OnlineLabel,
        ArrowIcon
    },

    props: {
        training: {
            type: Object
        },

        type: {
            type: String
        }
    },

    computed: {
        showUrl () {
            return this.training.show_url
        },

        image () {
            return this.training.profile_image_url
        },

        title () {
            return this.training.title
        },

        description () {
            return this.training.description
        },

        createdAt () {
            return this.training.created_at
        },

        price () {
            return this.training.price
        },

        registerUrl () {
            return this.training.register_url
        },

        isOnline () {
            return this.type === 'online'
        }
    }
}
</script>