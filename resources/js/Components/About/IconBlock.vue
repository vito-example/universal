<template>
    <div class="container margin_60">
        <div class="main_title">
            <h2 v-if="item.title.value" v-html="item.title.value"></h2>
            <div class="text-justify">
                <p v-if="item.sub_title.value" v-html="item.sub_title.value"></p>
            </div>
        </div>

        <div class="row">
            <template v-for="(iconCardFields,key) in item.fields.value" :key="key">
                <about-card
                    :url="getFieldValue(iconCardFields,'action_url')"
                    :icon="getFieldValue(iconCardFields,'icon')"
                    :title="getFieldValue(iconCardFields,'title')"
                    :description="getFieldValue(iconCardFields,'sub_title')"
                />
            </template>

        </div><!--End row-->

        <br>
        <template v-if="item.action_button_title.value && !isAuth()">
            <div class="text-center">
                <a :href="item.action_button_url.value" class=" button_outline large">
                    {{ item.action_button_title.value }}
                </a>
            </div>
        </template>
    </div>
</template>

<script>
import AboutCard from "@/Components/About/AboutCard";

export default {
    components: {
        AboutCard
    },
    props: {
        item: {
            type: Object
        }
    },
    methods: {
        getFieldValue (fields, key) {
            var value = undefined
            fields.map((field) => {
                if (value === undefined && field.name == key) {
                    value = field.value
                }
            })

            return value
        }
    }
}
</script>
