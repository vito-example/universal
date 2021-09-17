<template>
    <button
        :type="type"
        class="disabled:opacity-50 text-gray-800 inline-flex justify-center items-center px-5 py-3 bg-white border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-wider hover:bg-opacity-90 focus:outline-none transition ease-in-out duration-150"
        @click="$emit('click', $event)"
        v-bind:disabled="disabled"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    }
}
</script>
