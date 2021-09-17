<template>
    <portal class="event-single">
        <template v-slot:breadcrumb>
            <breadcrumb-item>
                <inertia-link :href="route('event.index')">
                    {{ __('Events') }}
                </inertia-link>
            </breadcrumb-item>
            <breadcrumb-item :active="true">
                {{ item.title }}
            </breadcrumb-item>
        </template>
        <template v-slot:main>
            <div class="container margin_60">
                <div class="row">
                    <div class="col-md-9">
                        <div class="box_style_1">
                            <div class="indent_title_in">
                                <i class="pe-7s-news-paper"></i>
                                <h3>{{ item.title }}</h3>
                            </div>
                            <div class="wrapper_indent">
                                <span v-html="item.description"></span>
                            </div>

                            <template v-if="item.organizers.length">
                                <hr class="styled_2">
                                <event-connections v-if="item.organizers.length" :connections="item.organizers" :title="__('Event Organizers')" icon="pe-7s-users"></event-connections>
                            </template>

                            <template v-if="item.sponsors.length">
                                <hr class="styled_t">
                                <event-connections v-if="item.sponsors.length" :connections="item.sponsors" :title="__('Event Sponsors')"></event-connections>
                            </template>

                            <template v-if="item.speakers.length">
                                <hr class="styled_t">
                                <event-connections v-if="item.speakers.length" :connections="item.speakers" :title="__('Event Speakers')"></event-connections>
                            </template>

                            <template v-if="item.files.length">
                                <hr class="styled_2">

                                <div class="indent_title_in">
                                    <i class="pe-7s-cloud-download"></i>
                                    <h3>{{ __('Event Downloads') }}</h3>
                                </div>
                                <div class="wrapper_indent">
                                    <div class="row">
                                        <template v-for="file in item.files">
                                            <div class="col-md-6 col-sm-3">
                                                <a target="_blank" style="color: white;font-weight: bold;" download :href="file.file" class="btn btn-success btn-pill button_download hvr-sweep-to-right">
                                                    {{ file.name }}
                                                </a>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                    <aside class="col-md-3">

<!--                        <template v-if="item.banners.length" v-for="banner in item.banners">-->
<!--                            <a :href="getBannerValueByKey(banner,'url')" target="_blank" class="d-block add_bottom_30">-->
<!--                                <img class="img-thumbnail" :alt="getBannerValueByKey(banner,'name')" :src="getBannerValueByKey(banner,'image')">-->
<!--                            </a>-->
<!--                        </template>-->

                        <template v-if="item.permission && item.permission.can_register">
                            <h4 class="font-weight-bold">{{ __('Event How yo apply') }}</h4>
                            <register-event
                                class="w-full rounded my-4"
                                :can-register="item.can_register"
                                :event="item">
                            </register-event>
                        </template>

                        <template v-if="item.permission && item.permission.can_open_conference">
                            <h4 class="font-weight-bold">{{ __('Event Conference') }}</h4>
                            <inertia-link :href="item.conference_url">
                                <c-button
                                    class="btn btn-info rounded text-uppercase font-weight-bold mr-3 mb-4 px-2">
                                    {{ __('Conference Redirect') }}
                                </c-button>
                            </inertia-link>
                        </template>

                        <template v-if="item.moderator">
                            <div class="box_side"><h5 class="font-weight-bold">{{ __('Moderator name') }}</h5>
                                <p>{{ item.moderator.name }}</p>
                            </div>
                            <template v-if="item.moderator.phone">
                                <hr class="styled">
                                <div class="box_side"><h5 class="font-weight-bold">{{ __('Moderator Phone') }}</h5>
                                    <p><a :href="'tel://'+item.moderator.phone">{{ item.moderator.phone }}</a><br></p>
                                </div>
                            </template>
                            <template v-if="item.moderator.email">
                                <hr class="styled">
                                <div class="box_side"><h5 class="font-weight-bold">{{ __('Moderator mail') }}</h5>
                                    <p><a :href="'mailto::'+item.moderator.email">{{ item.moderator.email }}</a></p>
                                </div>
                            </template>
                        </template>
                        <event-share></event-share>
                    </aside>
                </div>
            </div>

            <register-event-modal></register-event-modal>
            <event-info-modal></event-info-modal>
        </template>
    </portal>
</template>

<script>
import Portal from '@/Layouts/Portal'
import CardEvent from "@/Components/Event/CardEvent";
import RegisterEventModal from "@/Components/Event/RegisterEventModal";
import RegisterEvent from "@/Components/Event/RegisterEvent";
import EventInfoModal from "@/Components/Event/EventInfoModal";
import emitter from "@/Plugins/bus";
import BreadcrumbItem from "@/Components/BreadcrumbItem";
import CButton from "@/CoreUi/components/Button";
import CCard from "@/CoreUi/components/Card";
import EventConnections from "@/Components/Event/EventConnections";
import SocialShare from "@/Components/SocialShare";
import EventShare from "@/Components/Event/EventShare";

export default {
    components: {
        EventShare,
        SocialShare,
        EventConnections,
        BreadcrumbItem,
        EventInfoModal,
        RegisterEventModal,
        CardEvent,
        RegisterEvent,
        Portal,
        CButton,
        CCard
    },
    props: {
        item: {
            type: Object,
            default: {}
        },
        related_items: {
            type: Array,
            default: []
        }
    },
    methods: {
        showEventCalendar() {
            emitter.emit('eventInfoModal', {
                item: this.item,
                isCreate: false
            })
        },
        getBannerValueByKey (fields, key) {
            var value = ''
            fields.forEach((field) => {
                if (!value && field.key === key) {
                    value = field.value
                }
            })
            return value
        }
    }
}
</script>

