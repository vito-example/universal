<template>
    <div class="paginations flex center margin_bottom">

            <template
                v-for="(link, index) in links.slice(1, -1)"
                :key="index"
            >
                <inertia-link
                    class="page_number medium flex center main_blue"
                    :class="link.active ? 'active' : ''"
                              :href="link.url">
                    {{ label(link.label) }}
                </inertia-link>
            </template>
    </div>
</template>

<script>
export default {
    props: {
        links: Array
    },
    methods: {
        label(label) {
            return parseInt(label) < 10 ? `0${label}` : label;
        }
    }
}
</script>
