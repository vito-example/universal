<template>
    <div class="sub_header bg_2" v-bind:style="{ backgroundImage: 'url(' + item.header_image.value + ')' }">
        <div id="intro_txt" class="animated fadeInDown">
            <h1 v-if="item.title.value" v-html="item.title.value" />
            <p v-if="item.sub_title.value" v-html="item.sub_title.value"></p>
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
