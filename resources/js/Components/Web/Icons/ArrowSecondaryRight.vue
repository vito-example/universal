<template>
    <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 1L7 7L1 13" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</template>
<script>
import Icon from "@/Components/Web/Icons/Icon";

export default {
    components: {Icon},
    props: {
        width: {
            type: Number
        },

        height: {
            type: Number
        }
    }
}
</script>