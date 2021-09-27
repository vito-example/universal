<template>
    <section class="team_home wrapper margin_bottom blog_home">
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
        <div class="team_list flex team_grid team_slider_home">
            <team-item
                v-for="(item, key) in items"
                :key="key"
                :item="item"
            />
        </div>
        <button class="arr" id="prev_team">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 32 32"
            >
                <g id="Layer_2" data-name="Layer 2" transform="translate(0.264)">
                    <g id="arrow-back">
                        <rect
                            id="Rectangle_57"
                            data-name="Rectangle 57"
                            width="32"
                            height="32"
                            transform="translate(31.736) rotate(90)"
                            opacity="0"
                        />
                        <path
                            id="Path_73"
                            data-name="Path 73"
                            d="M23.828,12.931H8.151l4.8-5.763a1.323,1.323,0,0,0-2.036-1.692L4.3,13.407a1.573,1.573,0,0,0-.119.2.168.168,0,0,1-.093.172,1.27,1.27,0,0,0,0,.952.168.168,0,0,0,.093.172,1.573,1.573,0,0,0,.119.2l6.609,7.931a1.323,1.323,0,1,0,2.036-1.692l-4.8-5.763H23.828a1.322,1.322,0,1,0,0-2.644Z"
                            transform="translate(1.287 1.609)"
                        />
                    </g>
                </g>
            </svg>
        </button>
        <button class="arr" id="next_team">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 32 32"
            >
                <g id="Layer_2" data-name="Layer 2" transform="translate(0.264)">
                    <g id="arrow-back">
                        <rect
                            id="Rectangle_57"
                            data-name="Rectangle 57"
                            width="32"
                            height="32"
                            transform="translate(31.736) rotate(90)"
                            opacity="0"
                        />
                        <path
                            id="Path_73"
                            data-name="Path 73"
                            d="M23.828,12.931H8.151l4.8-5.763a1.323,1.323,0,0,0-2.036-1.692L4.3,13.407a1.573,1.573,0,0,0-.119.2.168.168,0,0,1-.093.172,1.27,1.27,0,0,0,0,.952.168.168,0,0,0,.093.172,1.573,1.573,0,0,0,.119.2l6.609,7.931a1.323,1.323,0,1,0,2.036-1.692l-4.8-5.763H23.828a1.322,1.322,0,1,0,0-2.644Z"
                            transform="translate(1.287 1.609)"
                        />
                    </g>
                </g>
            </svg>
        </button>
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
