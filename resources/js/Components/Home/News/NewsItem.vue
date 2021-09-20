<template>
    <div class="blog_item">
        <div class="img_overlay">
            <lazy-image
                :src="image"
                :show-placeholder="true"
                :alt="title"
            />
        </div>
        <div class="text flex center">
            <div class="title bold" v-html="description">
            </div>
            <inertia-link :href="showUrl" class="read_more_rotate medium">
                {{__('Read More')}}
            </inertia-link>
        </div>
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
    }
}
</script>
