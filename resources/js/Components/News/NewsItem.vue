<template>
    <lazy-image
        :src="image"
        :show-placeholder="true"
        :alt="title"
    />
    <div class="cap">
        <div class="date">{{ createdAt}}</div>
        <div class="bold main_blue title">{{title}}</div>
        <div class="para" v-html="description">
        </div>
        <inertia-link :href="showUrl" class="read_more_rotate main_blue medium">
            {{__('Read More')}}
        </inertia-link
        >
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
