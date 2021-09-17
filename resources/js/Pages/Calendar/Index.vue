<template>
    <portal>
        <template v-slot:breadcrumb>
            <breadcrumb-item>
                <inertia-link :href="route('event.index')">
                    {{ __('Events') }}
                </inertia-link>
            </breadcrumb-item>
            <breadcrumb-item :active="true">
                {{ __('Calendar') }}
            </breadcrumb-item>
        </template>
        <template v-slot:main>
            <div class="col-md-12">
                <custom-calendar></custom-calendar>
            </div>

            <event-info-modal></event-info-modal>
        </template>
    </portal>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import NPagination from '@/Components/Pagination'
import CardEvent from "@/Components/Event/CardEvent";
import RegisterEventModal from "@/Components/Event/RegisterEventModal";
import EventInfoModal from "@/Components/Event/EventInfoModal";
import Portal from "@/Layouts/Portal";
import BreadcrumbItem from "@/Components/BreadcrumbItem";
import CustomCalendar from "@/Components/Calendar/CustomCalendar";

export default {
    components: {
        BreadcrumbItem,
        Portal,
        EventInfoModal,
        CardEvent,
        AppLayout,
        NPagination,
        RegisterEventModal,
        CustomCalendar
    },
    props: {
        current_date: {
            type: String,
            default: ''
        }
    }
}
</script>
