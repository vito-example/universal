<template>
    <landing class="about-page">
        <template v-slot:main>
            <breadcrumb :active="__('ჩვენ შესახებ')" />

            <div class="content container container--small margin-top-40">
                <template v-for="(item,key) in page" v-if="page.length">
                    <template v-if="item.key === 'background_image'">
                        <img :src="item.fields.header_image.value" v-if="item.fields.header_image.value"
                             class="about-cover border-radius-10" alt="">
                    </template>
                    <template v-else-if="item.key === 'section_one' || item.key === 'section_two'">

                        <h2 class="font-weight-600 margin-top-40">{{item.fields.title.value}}</h2>

                        <div class="font-size-sm font-weight-300 line-height-default margin-top-24"
                             v-html="item.fields.description.value">
                        </div>

                        <div class="margin-top-40">
                            <div class="row">
                                <div class="col-6 col-lg-6 col-xs-12 margin-bottom-xs-20" v-for="(item,key) in item.fields.fields.value"
                                     v-if="item.fields.fields.value.length">
                                    <img :src="item[0].value" class="about-thumb border-radius-10" alt="">
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-else-if="item.key === 'galleries'">
                        <gallery-section :gallery="item.fields.fields.value"/>

                        <!--<h4 class="font-weight-600 margin-top-48">{{ item.fields.title.value }}</h4>

                        <div class="margin-top-32">
                            <div class="row">
                                <div class="col-3 col-lg-3" v-for="(item,key) in item.fields.fields.value"
                                     v-if="item.fields.fields.value.length">
                                    <img :src="item[0].value" class="about-gallery-thumb border-radius-10" alt="">
                                </div>
                            </div>
                        </div>-->
                    </template>
                </template>
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
        page: {
            type: Array
        },
    }
}
</script>
