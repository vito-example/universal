<template>
    <landing>
        <template v-slot:main>
            <breadcrumb v-if="page.length" :item="page[0]['fields']"/>
            <section class="projects_page wrapper">
                <div class="project_grid">
                    <project-item
                        v-for="item in items.data"
                        :item="item"
                        :key="item.id"
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
import ProjectItem from "@/Components/Project/ProjectItem"
import Breadcrumb from "@/Components/BreadcrumbItem"
import Pagination from "@/Components/Pagination/Pagination";

export default {
    components: {
        Landing,
        ProjectItem,
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
