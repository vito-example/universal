<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :item="page[0]['fields']"/>
            <section class="about_page wrapper margin_bottom">
                <template v-if="page[1]['fields']">
                    <div class="flex">
                        <div class="img_overlay" >
                            <lazy-image
                                :src="page[1]['fields']['banner_image']['value']"
                                :show-placeholder="true"
                                :alt="title"
                            />
                        </div>
                        <div class="text">
                            <div class="title">
                                <div class="ab medium">{{page[1]['fields']['title']['value']}}</div>
                                <div class="main main_blue bold">
                                    {{page[1]['fields']['description']['value']}}
                                </div>
                            </div>
                            <div class="para" v-html="page[1]['fields']['content']['value']">
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="page[2]['fields']">
                    <div class="flex">
                        <div class="text">
                            <div class="title">
                                <div class="main main_blue bold">
                                    {{ page[2]['fields']['description']['value']}}
                                </div>
                            </div>
                            <div class="para"  v-html="page[2]['fields']['content']['value']">
                            </div>
                        </div>
                        <div class="img_overlay">
                            <lazy-image
                                :src="page[2]['fields']['banner_image']['value']"
                                :show-placeholder="true"
                                :alt="title"
                            />
                        </div>
                    </div>
                </template>
            </section>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import Breadcrumb from "@/Components/BreadcrumbItem"
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        Landing,
        Breadcrumb,
        LazyImage
    },
    props: {
        items: {
            type: Array
        },
        route: {
            type: String
        },
        page: {
            type: Array
        }
    }
}
</script>
