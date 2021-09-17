<template>
    <div v-show="message" class="validation_error">
        <p>
            {{ message }}
        </p>
    </div>
</template>

<script>
    export default {
        props: ['message']
    }
</script>
