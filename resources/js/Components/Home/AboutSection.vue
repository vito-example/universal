<template v-show="item">
    <section class="who_we_are flex wrapper margin_bottom">
        <div class="img_overlay">
            <lazy-image
                :src="item.fields.banner_image.value"
                :alt="item.fields.title.value"
                :show-placeholder="true"
                class="border-radius-10"
            />
        </div>
        <div class="div">
            <div class="main_blue bold">{{item.fields.title.value}}</div>
            <div class="poppins" v-html="item.fields.description.value">
            </div>
            <inertia-link :href="route('about.index')">
                <button class="main_btn">{{__('Read More')}}</button>
            </inertia-link>
        </div>
    </section>

</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        LazyImage,
    },

    props: {
        item: Array
    },
}
</script>
