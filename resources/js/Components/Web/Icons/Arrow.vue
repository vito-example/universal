<template>
    <icon :width="width" :height="height" viewBox="0 0 8 14" fill="none">
        <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </icon>
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