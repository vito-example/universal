<template>
    <div class="paginations flex center margin_bottom">
        <template v-for="(link, i) in links" :key="i">
            <inertia-link :href="link.url"
                class="page_number medium flex center main_blue"
                v-bind:class="{
                           'active': link.active,
                       }"
                v-html="link.label">

            </inertia-link>
        </template>
    </div>
</template>

<script>
export default {
    props: [
        'currentPage',
        'firstPageUrl',
        'from',
        'lastPage',
        'lastPageUrl',
        'links',
        'nextPageUrl',
        'path',
        'perPage',
        'prevPageUrl',
        'to',
        'total',
    ]
}
</script>

<style scoped>

</style>
