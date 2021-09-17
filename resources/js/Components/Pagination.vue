<template>
    <div class="flex justify-end">
        <div class="rounded-md shadow flex overflow-hidden">
            <template v-for="(link, i) in links" :key="i">
                <component :is="link.url ? 'inertia-link' : 'div'"
                           :href="link.url || ''"
                           class="py-3 px-5 text-sm text-center border-r border-gray-100 last:border-none"
                           v-bind:class="{
                           'bg-white text-gray-800': !link.active,
                           'bg-orange-400 text-white': link.active,
                           'hover:bg-gray-50': link.url && !link.active,
                       }"
                           v-html="link.label"
                />
            </template>
        </div>
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
