<template>
    <inertia-link
        :href="route('home.index')"
        :class="customClass"
    >
        <img
            :src="logoUrl"
            :height="height"
            :alt="alt"
        >
    </inertia-link>
</template>

<script>
export default {
    name: "Logo",

    props: {
        height: Number,
        alt: String,
        customClass: String
    },

    computed: {
        /**
         *
         * @returns {string}
         */
        logoUrl() {
            return `/logo/logo.svg`
        }
    }
}
</script>
