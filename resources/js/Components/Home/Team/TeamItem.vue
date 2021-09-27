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
            <div class="info" v-html="description">
            </div>
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
        name () {
            return this.item.name
        },
        position () {
            return this.item.position
        },
        description () {
            return this.item.about
        },
    }
}
</script>
