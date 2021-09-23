<template>
    <landing>
        <template v-slot:main>
            <breadcrumb v-if="page.length" :item="page[0]['fields']"/>
            <section class="services_page wrapper">
                <section class=" wrapper margin_bottom">
                    <div class="service_boxes">
                        <service-item
                            v-for="item in items.data"
                            :item="item"
                            :key="item.id"
                        />
                    </div>
                </section>
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
import ServiceItem from "@/Components/Service/ServiceItem"
import Breadcrumb from "@/Components/BreadcrumbItem"
import Pagination from "@/Components/Pagination/Pagination";

export default {
    components: {
        Landing,
        ServiceItem,
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
