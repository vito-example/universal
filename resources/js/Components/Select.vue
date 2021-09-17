<template>
    <select
        :multiple="multiple"
        class="border-gray-300 rounded-md focus:ring-orange-400 focus:border-orange-500 disabled:opacity-100"
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
    props: ['value', 'options', 'placeholder', 'disabled','multiple'],

    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>

