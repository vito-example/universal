<template>
    <div class="g_item img_overlay">
        <lazy-image
            :src="image"
            :show-placeholder="true"
            :alt="title"
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
            type: Object
        }
    },

    computed: {
        image () {
            return this.getValueByFields('image')
        },

        title () {
            return `No Image`
        }
    },

    methods: {
        getValueByFields(key) {
            return this.item.filter((item) => item.name === key)?.[0]?.value
        }
    }
}
</script>
