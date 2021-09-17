<template>
    <portal class="new-company-page">
        <template v-slot:breadcrumb>
            <breadcrumb-item>
                <inertia-link :href="route('company.index')">
                    {{ __('My Companies') }}
                </inertia-link>
            </breadcrumb-item>
            <breadcrumb-item :active="true">
                {{ __('Create Company') }}
            </breadcrumb-item>
        </template>

        <template v-slot:main>
            <div class="col-md-12">
                <ul class="nav page-nav">
                    <li class="nav-item">
                        <inertia-link :href="route('profile.show')" class="nav-link">{{ __('Profile') }}</inertia-link>
                    </li>
                    <li class="nav-item ml-2">
                        <inertia-link :href="route('company.index')" class="nav-link active">{{ __('My Companies') }}</inertia-link>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 mt-4">
                <c-form :options="options"></c-form>
            </div>
        </template>
    </portal>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import Portal from "@/Layouts/Portal";
import BreadcrumbItem from "@/Components/BreadcrumbItem";
import CCard from "@/CoreUi/components/Card";
import CardCompany from "@/Components/Company/CardCompany";
import CForm from "@/Components/Company/Form";

export default {
    props: {
        options: {
            type: Array
        }
    },
    components: {
        CardCompany,
        BreadcrumbItem,
        Portal,
        AppLayout,
        JetSectionBorder,
        CCard,
        CForm
    },
}
</script>
