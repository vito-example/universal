<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :item="page[0]['fields']" />

            <section class="blogs_page wrapper margin_bottom">
                <lazy-image
                    :src="item.profile_image"
                    :show-placeholder="true"
                    :alt="title"
                />
                <div class="cap">
                    <div class="date">{{item.created_at}}</div>
                    <div class="title bold main_blue">{{item.title}}</div>
                    <div class="para" v-html="item.description"></div>
                </div>
            </section>
            <gallery-section :gallery="gallery" />
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
    computed: {
        gallery () {
            return this.item?.gallery?.galleries?.fields?.map(item => {
                item[0].value = item?.[0]?.file?.full_src
                return item
            })
        }
    },

    mounted () {
        console.log(this.gallery)
    }
}
</script>
