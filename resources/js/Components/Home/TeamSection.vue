<template>
    <section class="team_home wrapper margin_bottom">
        <div class="section_head flex">
            <div class="main_titles">
                <div class="title_bg bold">
                    {{ page.fields.background_title?.value }}
                </div>
                <div class="title bold main_blue" v-html="page.fields.title?.value">

                </div>
            </div>
            <inertia-link :href="route('team.index')">
                <button class="view_all_btn">{{__('View All')}}</button>
            </inertia-link>
        </div>
        <div class="team_list flex team_grid">
            <team-item
                v-for="(item, key) in items"
                :key="key"
                :item="item"
            />
        </div>
    </section>
</template>

<script>
import teamItem from "@/Components/Home/Team/TeamItem"

export default {
    components: {
        teamItem
    },

    props: {
        page: Array,
        items: Array
    },
}
</script>
