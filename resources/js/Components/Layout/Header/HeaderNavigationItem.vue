<template>
    <li class="nav__item">
      <inertia-link :href="to" class="nav__link">
        <template v-if="label">
          {{ label}}
        </template>
      </inertia-link>
    </li>
</template>

<script>
export default {
    name: "HeaderNavigationItem",

    props: {
        to: String,
        label: String,
    }
}
</script>
