<template>
    <input
        class="form__element"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
        autocomplete="off"
    >
</template>

<script>
    export default {
        props: ['modelValue'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

