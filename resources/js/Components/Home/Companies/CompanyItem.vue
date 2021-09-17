<template>
    <a
            :href="href"
            class="company-item flex items-center width-full"
    >
        <lazy-image
                :src="image"
                class="width-full"
        />
    </a>
</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        LazyImage
    },

    props: {
        company: {
            type: Object
        }
    },

    computed: {
        href () {
            return this.getValueByFields('action_url')
        },

        image () {
            return this.getValueByFields('image')
        }
    },

    methods: {
        getValueByFields(key) {
            return this.company.filter((item) => item.name === key)?.[0]?.value
        }
    }
}
</script>