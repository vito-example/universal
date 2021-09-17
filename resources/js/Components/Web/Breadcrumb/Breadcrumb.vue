<template>
    <div class="container">
        <ul class="breadcrumb margin-top-14">
            <li>
                <inertia-link
                        :href="route('home.index')"
                        class="underline-none"
                >
                    {{ __('მთავარი') }}
                </inertia-link>
            </li>

            <li
                    v-for="(item, index) in items"
                    :key="index"
            >
                <inertia-link
                        :href="route(item.route)"
                        class="underline-none"
                >
                    {{ __(item.label) }}
                </inertia-link>
            </li>

            <li class="is-active">{{ active }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        items: {
            type: Array
        },

        active: {
            type: String
        }
    }
}
</script>
