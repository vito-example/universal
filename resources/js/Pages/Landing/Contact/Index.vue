<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :active="__('კონტაქტი')"/>

            <template v-if="desktop">
                <contact-desktop :page="page" />
            </template>

            <template v-else>
                <contact-mobile :page="page" />
            </template>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import LocationIcon from "@/Components/Web/Icons/Location";
import PhoneIcon from "@/Components/Web/Icons/PhoneSecondary";
import MessageIcon from "@/Components/Web/Icons/Message";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import CustomSelect from "@/Components/Web/Select/Select";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CInputLabel from "@/CoreUi/components/InputLabel";
import ContactDesktop from "@/Components/Contact/ContactDesktop";
import ContactMobile from "@/Components/Contact/ContactMobile";

export default {
    components: {
        Landing,
        Breadcrumb,
        LocationIcon,
        PhoneIcon,
        MessageIcon,
        CustomSelect,
        CInput,
        CInputError,
        CInputLabel,
        ContactDesktop,
        ContactMobile
    },

    props: {
        page: {
            type: Array
        }
    },

    inject: ["mq"],

    computed: {
        desktop () {
            return this.mq.lgPlus
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('contact.send'), {

            })
        },
    }

}
</script>
