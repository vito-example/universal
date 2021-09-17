<template>
    <portal>
        <template v-slot:breadcrumb>
            <breadcrumb-item :active="true">
                {{ __('My Companies') }}
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
                <inertia-link
                    class="btn btn-danger mt-3 px-4 font-weight-bold"
                    :href="route('company.create')">
                    {{ __('Add Company') }}
                </inertia-link>
            </div>
            <div class="col-md-12 mt-4">
                <div class="row">
                    <template v-for="item in companies">
                        <card-company :options="options" class="col-sm-6 col-md-4" :item="item"></card-company>
                    </template>
                </div>
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

export default {
    props: {
        companies: {
            type: Array
        },
        options: {
            type: Object
        },
    },

    components: {
        CardCompany,
        BreadcrumbItem,
        Portal,
        AppLayout,
        JetSectionBorder,
        CCard
    },
}
</script>
