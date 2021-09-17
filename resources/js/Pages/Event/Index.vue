<template>
    <portal custom-class="events-page">
        <template v-slot:breadcrumb>
            <breadcrumb-item :active="true">
                {{ __('Events') }}
            </breadcrumb-item>
        </template>
        <template v-slot:main>
            <template v-for="item in events_data.data">
                <card-event
                    class="col-sm-6 col-md-6"
                    :item="item">
                </card-event>
            </template>

            <div class="col-12">
                <pagination
                    :current-page="events_data.current_page"
                    :per-page="events_data.per_page"
                    :total="events_data.total"
                    :links="events_data.links"
                />
            </div>

            <register-event-modal></register-event-modal>
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
import Pagination from "@/Components/Pagination/Pagination";

export default {
    components: {
        BreadcrumbItem,
        Portal,
        EventInfoModal,
        CardEvent,
        AppLayout,
        NPagination,
        RegisterEventModal,
        Pagination
    },
    props: {
        events_data: {
            type: Object,
            default: {}
        }
    },

    mounted() {
    }
}
</script>
