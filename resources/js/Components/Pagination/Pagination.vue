<template>
    <nav>
        <ul class="pagination">
            <li
                v-for="(link, index) in links.slice(1, -1)"
                class="page-item"
                :class="link.active ? 'active' : ''"
                :key="index"
            >
                <a class="page-link" :href="link.url">
                    {{ link.label }}
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        links: Array
    }
}
</script>
