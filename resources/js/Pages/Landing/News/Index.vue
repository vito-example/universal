<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :item="page[0]['fields']" />
            <section class="blogs_page wrapper">
                <div
                    v-for="item in items.data"
                    :key="item.id"
                    class="blog_item"
                >
                    <news-item
                        :item="item"
                        class="margin-bottom-sm-50"
                    />
                </div>

                <div class="paginations flex center margin_bottom">
                    <button class="page_number medium flex center main_blue active">
                        01
                    </button>
                    <button class="page_number medium flex center main_blue">02</button>
                    <button class="page_number medium flex center main_blue">03</button>
                    <button class="page_number medium flex center main_blue">04</button>
                </div>
            </section>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import NewsItem from "@/Components/News/NewsItem"
import Breadcrumb from "@/Components/BreadcrumbItem"

export default {
    components: {
        Landing,
        NewsItem,
        Breadcrumb
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
