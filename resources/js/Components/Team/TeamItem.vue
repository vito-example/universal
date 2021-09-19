<template>
        <inertia-link :href="showUrl" class="img_overlay">
            <lazy-image
                :src="image"
                :show-placeholder="true"
                :alt="title"
            />
            <div class="caption">
                <div class="name">{{name}}</div>
                <div class="pos">{{position}}</div>
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
        name () {
            return this.item.name
        },
        position () {
            return this.item.position
        },
        image () {
            return this.item.profile_image
        },
    }
}
</script>
