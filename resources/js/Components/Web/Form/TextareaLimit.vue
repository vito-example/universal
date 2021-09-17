<template>
    <div class="text-limit">
        <slot />

        <div class="text-limit__counter">
            {{ value }}/{{ max }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        max: {
            type: Number,
            default: 400
        },

        value: {
            type: Number
        }
    },

    computed: {

    }
}
</script>