<template>
    <li class="breadcrumb-item" :class="active ? 'active' : ''">
        <slot></slot>
    </li>
</template>

<script>
export default {
    props: ['active']
}
</script>
