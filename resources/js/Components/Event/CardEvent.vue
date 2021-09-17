<template>
    <div>
        <c-card class="has-shadow border-0 event-card">
            <template v-slot:header>
                <div class="flex-sm-up">
                    <div class="card-image">
                        <slot :item="item" name="imageHref">
                            <inertia-link class="no-underline hover:underline text-black float-left" :href="item.show_url">
                                <img alt="Placeholder" class="img-thumbnail" :src="item.profile_image_url">
                            </inertia-link>
                        </slot>
                    </div>

                    <div class="ml-auto text-right w-sm-up-70">
                        <span class="d-block">{{ item.start_date }}</span>
                        <span class="d-block font-weight-bold">{{ title }}</span>
                        <span>{{ item.organizers }}</span>
                    </div>
                </div>
            </template>

            <template v-slot:body>
                <div class="color-gray" v-html="description"></div>
            </template>

            <template v-slot:footer>
                <div class="d-flex align-items-center">
                    <template v-if="item.permissions.can_open_conference">
                        <slot :item="item" name="conferenceButton">
                            <inertia-link :href="item.conference_url">
                                <c-button
                                    class="btn btn-info btn-pill text-uppercase font-weight-bold mr-3 px-2">
                                    {{ __('Open Conference') }}
                                </c-button>
                            </inertia-link>
                        </slot>
                    </template>
                    <template v-else-if="item.permissions.can_register">
                        <register-event
                            :can-register="item.can_register"
                            :event="item"></register-event>
                    </template>

                    <slot :item="item" name="learnMoreButton">
                        <inertia-link  :href="item.show_url">
                            <c-button class="btn btn-warning btn-pill text-uppercase font-weight-bold mr-3 px-2">
                                {{ __('Learn more') }}
                            </c-button>
                        </inertia-link>
                    </slot>
                </div>
            </template>
        </c-card>
    </div>
</template>

<script>
import { stringLimit } from '@/Helpers/string';
import RegisterEvent from "@/Components/Event/RegisterEvent";
import CCard from "@/CoreUi/components/Card";
import CButton from "@/CoreUi/components/Button";

export default {
    components: {
        RegisterEvent,
        CCard,
        CButton
    },
    props: {
        item: {
            type: Object,
            default: {}
        }
    },

    computed: {
        title () {
            return stringLimit(this.item.title, 110)
        },

        description () {
            return stringLimit(this.item.description, 110)
        }
    }
}
</script>
