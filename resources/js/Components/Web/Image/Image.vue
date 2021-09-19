<template>
    <v-lazy-image
            :src="src"
            :src-placeholder="placeholder"
    />
</template>

<script>
import VLazyImage from "v-lazy-image";

export default {
    components: {
        VLazyImage
    },

    props: {
        src: {
            type: String
        },

        showPlaceholder: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        placeholder () {
            return this.showPlaceholder ? '/placeholders/blank.gif' : ''
        }
    }
}
</script>
