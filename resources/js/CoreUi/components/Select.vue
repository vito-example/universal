<template>
    <select
        class="form-control"
        :class="{'bg-gray-50': disabled}"
        @input="$emit('input', $event.target.value)"
        @blur="$emit('blur', $event)"
        :disabled="disabled">
        <option v-if="placeholder" value="" disabled selected>
            {{ placeholder }}
        </option>
        <option
            v-for="option in options"
            :value="option.value"
            :selected="option.value === value">
            {{ option.label }}
        </option>
    </select>
</template>

<script>
export default {
    props: ['value', 'options', 'placeholder', 'disabled'],

    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>
