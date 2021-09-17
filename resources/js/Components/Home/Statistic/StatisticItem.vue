<template>
    <div class="statistic__item text-center">
        <div class="font-size-xxl font-weight-600">{{ value }}</div>
        <div class="font-weight-300 padding-top-19">{{ key }}</div>
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
        key () {
            return this.getValueByFields('key')
        },

        value () {
            return this.getValueByFields('value')
        }
    },

    methods: {
        getValueByFields(key) {
            return this.statistic.filter((item) => item.name === key)?.[0]?.value
        }
    }
}
</script>