<template>
    <section class="projects_section_home margin_bottom">
        <div class="section_head flex wrapper">
            <div class="main_titles">
                <div class="title_bg bold" style="opacity: 0.21">
                    {{ page.fields.background_title?.value }}

                </div>
                <div class="title bold" style="color: #f3f3f3" v-html="page.fields.title?.value">
                </div>
            </div>
            <inertia-link :href="route('project.index')">
                <button class="view_all_btn dark">{{__('View All')}}</button>
            </inertia-link>
        </div>
        <div class="project_slider_track">
            <div class="projects_slider flex">
                <project-item
                    v-for="(item, key) in items"
                    :key="key"
                    :item="item"
                />
            </div>
            <button class="arr" id="project_prev">
                <svg
                    id="arrow-ios-back"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                >
                    <rect
                        id="Rectangle_28"
                        data-name="Rectangle 28"
                        width="24"
                        height="24"
                        transform="translate(24) rotate(90)"
                        opacity="0"
                    />
                    <path
                        id="Path_71"
                        data-name="Path 71"
                        d="M13.83,19a1,1,0,0,1-.78-.37l-4.83-6a1,1,0,0,1,0-1.27l5-6a1,1,0,0,1,1.54,1.28L10.29,12l4.32,5.36A1,1,0,0,1,13.83,19Z"
                    />
                </svg>
            </button>
            <button class="arr" id="project_next">
                <svg
                    id="arrow-ios-back"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                >
                    <rect
                        id="Rectangle_28"
                        data-name="Rectangle 28"
                        width="24"
                        height="24"
                        transform="translate(24) rotate(90)"
                        opacity="0"
                    />
                    <path
                        id="Path_71"
                        data-name="Path 71"
                        d="M13.83,19a1,1,0,0,1-.78-.37l-4.83-6a1,1,0,0,1,0-1.27l5-6a1,1,0,0,1,1.54,1.28L10.29,12l4.32,5.36A1,1,0,0,1,13.83,19Z"
                    />
                </svg>
            </button>
        </div>
    </section>
</template>

<script>
import ProjectItem from "@/Components/Home/Projects/ProjectItem"

export default {
    components: {
        ProjectItem
    },

    props: {
        page: Array,
        items: Array
    },
}
</script>
