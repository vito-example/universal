<template>
    <div class="container_white_bg">
        <div class="container margin_60">
            <p v-html="item.content.value">
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object
        }
    }
}
</script>
