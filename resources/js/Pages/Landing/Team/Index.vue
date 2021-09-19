<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :item="page[0]['fields']"/>
            <section class="team_page wrapper team_grid margin_bottom">
                <team-item
                    v-for="item in items"
                    :item="item"
                    :key="item.id"
                    />
            </section>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import TeamItem from "@/Components/Team/TeamItem"
import Breadcrumb from "@/Components/BreadcrumbItem"

export default {
    components: {
        Landing,
        TeamItem,
        Breadcrumb,
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
