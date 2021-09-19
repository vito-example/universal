<template>
    <landing class="home">
        <template v-slot:main>
            <template v-for="(item,key) in page" v-if="page.length">
                <template v-if="item.key === 'slider'">
                    <hero-section :item="item"/>
                </template>
            </template>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import HeroSection from "../../../Components/Home/HeroSection";

export default {
    components: {
        Landing,
        HeroSection,
    },
    props: {
        page: {
            type: Array
        },
    },
    methods: {
        getValueByFields(fields, key) {
            let value = '';
            fields.forEach((item) => {
                if (!value && item.name === key) {
                    value = item.value
                }
            })
            return value
        },
        stringLimit (string, limit = 100) {
            if (string) {
                return string.length > limit ? `${string.substring(0, limit)} ...` : string;
            }
            return '';
        }
    }
}
</script>
