<template>
    <div class="card border-0">
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

        <time class="card__date padding-top-21">{{ createdAt }}</time>

        <inertia-link
                :href="showUrl"
                :title="title"
                class="text-decoration-none"
        >
            <h4 class="card__title line-height-22 padding-top-14">{{ title }}</h4>
        </inertia-link>
        <div
                class="card__text color-dark-green line-height-22 padding-top-0 opacity-60"
                v-html="description"
        />
    </div>
</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        LazyImage
    },

    props: {
        item: {
            type: String
        }
    },

    computed: {
        showUrl () {
            return this.item.show_url
        },

        image () {
            return this.item.profile_image
        },

        title () {
            return this.item.title
        },

        description () {
            return this.item.description
        },

        createdAt () {
            return this.item.created_at
        }
    }
}
</script>