<template>
    <div class="col-md-4 col-sm-4">
        <a class="box_feat" :href="url ? url : '#'">
            <i :class="icon" />
            <h3>{{ title }}</h3>
            <p v-html="description"></p>
        </a>
    </div>
</template>

<script>
export default {
    props: {
        icon: String,
        title: String,
        description: String,
        url: String
    }
}
</script>
