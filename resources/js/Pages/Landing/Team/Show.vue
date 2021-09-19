<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :item="page[0]['fields']"/>
            <section class="project_view_page blogs_page wrapper margin_bottom">
                <div class="flex">
                    <div class="div">
                        <div class="title main_blue bold">{{ item.name }}</div>
                        <div class="quote_box small border">
                            <div class="main_blue bold">
                                {{ item.position }}
                            </div>
                        </div>
                        <div class="para" v-html="item.about"></div>
                    </div>
                    <div style="max-width: 600px;">
                        <lazy-image
                            :src="item.profile_image"
                            :show-placeholder="true"
                            :alt="title"
                        />
                    </div>
                </div>
            </section>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import Breadcrumb from "@/Components/BreadcrumbItem"
import GallerySection from "@/Components/Sections/Gallery"
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        Landing,
        Breadcrumb,
        GallerySection,
        LazyImage
    },
    props: {
        item: {
            type: Object
        },
        page: {
            type: Array
        }
    },
}
</script>
