<template>
    <div class="calendar-items">
        <a :href="showUrl" class="text-sm text-gray-600 hover:text-gray-900" target="_blank">
            <i class="icon-fontello icon-eye-2"></i><!--{{ __('Add to google calendar') }}-->
        </a>
        <a :href="calendars.google" class="text-sm text-gray-600 hover:text-gray-900" target="_blank">
            <i class="icon icon-google color-google"></i><!--{{ __('Add to google calendar') }}-->
        </a>
        <a :href="calendars.outlook" class="text-sm text-gray-600 hover:text-gray-900" target="_blank">
            <i class="icon icon-outlook color-outlook"></i><!--{{ __('Add to outlook calendar') }}-->
        </a>
        <a :href="calendars.yahoo" class="text-sm text-gray-600 hover:text-gray-900" target="_blank">
            <i class="icon icon-yahoo color-yahoo"></i><!--{{ __('Add to yahoo calendar') }}-->
        </a>
    </div>
</template>

<script>
import {google, ics, outlook, yahoo} from "calendar-link";

export default {
    props: {
        item: {
            type: Object
        },

        calendarItemData: {
            type: Object
        }
    },
    data() {
        return {
            calendars: {}
        }
    },
    watch: {
        'calendarItemData'() {
            if (this.calendarItemData) {
                this.setCalendarLinks()
            }
        }
    },
    computed: {
        showUrl () {
            return this.item?.show_url
        }
    },
    created() {
        this.setCalendarLinks()
    },
    mounted() {
        this.setCalendarLinks()
    },
    methods: {
        setCalendarLinks() {
            if (!this.calendarItemData) {
                return
            }
            this.calendars = {
                google: google(this.calendarItemData),
                outlook: outlook(this.calendarItemData),
                office365: google(this.calendarItemData),
                yahoo: yahoo(this.calendarItemData),
                ics: ics(this.calendarItemData)
            }
        }
    }
}
</script>
