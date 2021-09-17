<template>
    <icon :width="width" :height="height">
        <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5"/>
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
