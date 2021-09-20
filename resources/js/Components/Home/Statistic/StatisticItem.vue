<template>
    <div class="counts">
        <div class="main_titles">
            <div class="title_bg bold">{{backgroundTitle}}</div>
            <div class="title bold main_blue" v-html="title"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        statistic: {
            type: Object
        }
    },

    computed: {
        backgroundTitle () {
            return this.getValueByFields('background_title')
        },

        title () {
            return `<span>${this.getValueByFields('background_title')}</span>${this.getValueByFields('title')}`
        }
    },

    methods: {
        getValueByFields(key) {
            return this.statistic.filter((item) => item.name === key)?.[0]?.value
        }
    }
}
</script>
