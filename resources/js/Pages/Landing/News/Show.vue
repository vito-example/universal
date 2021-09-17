<template>
    <landing class="about-page">
        <template v-slot:main>
            <breadcrumb
                    :items="breadcrumb"
                    :active="item.title"
            />

            <div class="content container container--small margin-top-40">
                <img :src="item.profile_image" alt="" class="about-cover border-radius-10">
                <time class="card__date">{{ item.created_at }}</time>
                <h2 class="font-weight-600 margin-top-24">{{item.title}}</h2>

                <div v-html="item.description" class="font-size-sm font-weight-300 line-height-default margin-top-32" />

                <gallery-section :gallery="item.gallery.galleries.fields" />
            </div>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import GallerySection from "@/Components/Sections/Gallery"

export default {
    components: {
        Landing,
        Breadcrumb,
        GallerySection
    },
    props: {
        item: {
            type: Object
        }
    },

    data () {
        return {
            breadcrumb: [
                {
                    label: 'სიახლეები',
                    route: 'news.index'
                }
            ]
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
