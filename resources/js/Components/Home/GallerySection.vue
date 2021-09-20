<template v-show="item">
    <section class="gallery_section wrapper margin_bottom">
        <div class="section_head flex">
            <div class="main_titles">
                <div class="title_bg bold">{{ item.fields.background_title?.value }}</div>
                <div class="title bold main_blue" v-html="item.fields.title?.value"></div>
            </div>
        </div>
        <div class="gallery_grid">
            <template
                v-for="(item, key) in item.fields.fields.value"
                :key="key"
            >
                <gallery-item
                    :item="item"
                />
            </template>
        </div>
    </section>
</template>

<script>
import GalleryItem from "@/Components/Home/Gallery/GalleryItem"

export default {
    components: {
        GalleryItem
    },

    props: {
        item: Array
    }
}
</script>
