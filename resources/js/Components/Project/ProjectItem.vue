<template>
    <inertia-link :href="showUrl">
        <div class="img_overlay">
            <lazy-image
                :src="image"
                :show-placeholder="true"
                :alt="title"
            />
        </div>
    </inertia-link>
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
    }
}
</script>
