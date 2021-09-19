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
                <pagination
                    :current-page="items.current_page"
                    :per-page="items.per_page"
                    :total="items.total"
                    :links="items.links"
                />
            </section>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import NewsItem from "@/Components/News/NewsItem"
import Breadcrumb from "@/Components/BreadcrumbItem"
import Pagination from "@/Components/Pagination/Pagination";

export default {
    components: {
        Landing,
        NewsItem,
        Breadcrumb,
        Pagination
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
