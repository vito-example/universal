<template>
    <div id="calendar">
        <general-error :message="form.error"></general-error>
        <div class="calendar-parent mb-4">
            <calendar-view
                :items="items"
                :show-date="showDate"
                :time-format-options="{ hour: 'numeric', minute: '2-digit' }"
                :disable-past="disablePast"
                :disable-future="disableFuture"
                :show-times="true"
                :display-period-uom="displayPeriodUom"
                :display-period-count="displayPeriodCount"
                :starting-day-of-week="startingDayOfWeek"
                :class="themeClasses"
                :period-changed-callback="periodChanged"
                :current-period-label="useTodayIcons ? 'icons' : ''"
                locale="ka"
                @click-date="onClickDay"
                @click-item="onClickItem">
                <template #dayHeader="{index, label}">
                    <div :key="getColumnDOWClass(index)" :class="getColumnDOWClass(index)" class="cv-header-day">
                        {{ __(label) }}
                    </div>
                </template>
                <template #header="{ headerProps }">
                    <calendar-view-header slot="header" :header-props="headerProps" @input="setShowDate" >
                        <template #label>
                            {{ getLabelTrans(headerProps.periodLabel) }}
                        </template>
                    </calendar-view-header>
                </template>
            </calendar-view>
        </div>
    </div>
</template>
<script>
import { CalendarView, CalendarViewHeader,CalendarMath } from "vue-simple-calendar"
import "../../../../node_modules/vue-simple-calendar/dist/style.css"
import "../../../../node_modules/vue-simple-calendar/static/css/default.css"
import "../../../../node_modules/vue-simple-calendar/static/css/holidays-us.css"
import NProgress from 'nprogress'
import GeneralError from "@/Components/GeneralError";
import emitter from "@/Plugins/bus";

export default {
    name: "App",
    components: {
        CalendarView,
        CalendarViewHeader,
        GeneralError
    },
    data() {
        return {
            form: {},
            showDate: this.thisMonth(1),
            message: "",
            disablePast: false,
            disableFuture: false,
            displayPeriodUom: "month",
            displayPeriodCount: 1,
            displayWeekNumbers: false,
            showTimes: true,
            useDefaultTheme: true,
            useHolidayTheme: true,
            useTodayIcons: false,
            displayFirstDate: '',
            displayLastDate: '',
            items: [],
            startingDayOfWeek: 1,
        }
    },
    computed: {
        themeClasses() {
            return {
                "theme-default": this.useDefaultTheme
            }
        }
    },
    methods: {
        getLabelTrans(periodLabel) {
            var labels = periodLabel.split(' ');
            return this.__(labels[0]) + ' ' + labels[1];
        },
        getColumnDOWClass(dayIndex) {
            return "dow" + ((dayIndex + this.startingDayOfWeek) % 7)
        },
        periodChanged(e) {
            this.displayFirstDate = e.displayFirstDate
            this.displayLastDate = e.displayLastDate
            this.getCalendarData()
        },
        thisMonth(d, h, m) {
            const t = new Date()
            return new Date(t.getFullYear(), t.getMonth(), d, h || 0, m || 0)
        },
        onClickDay(d) {
        },
        onClickItem(e) {
            emitter.emit('eventInfoModal', {
                item: e.originalItem.customData,
                isCreate: false
            })
        },
        setShowDate(d) {
            this.message = `Changing calendar view to ${d.toLocaleDateString()}`
            this.showDate = d
        },
        getCalendarData(){
            this.form = ''
            NProgress.start()
            axios.get(this.route('event.calendar.data'),{
                params: {
                    end_date: this.displayLastDate,
                    start_date: this.displayFirstDate
                }
            }).then(response => {
                this.items = response.data.data.calendar_data
                NProgress.done()
            }).catch((error) => {
                if (error.response.data) {
                    this.form.error = error.response.data.message
                }
                NProgress.done()
                NProgress.remove()
            })
        }
    },
}
</script>

<style>

#calendar {
    display: flex;
    flex-direction: row;
    font-family: Calibri, sans-serif;
    width: 95vw;
    min-width: 30rem;
    max-width: 100rem;
    min-height: 40rem;
    margin-left: auto;
    margin-right: auto;
}
.calendar-controls {
    margin-right: 1rem;
    min-width: 14rem;
    max-width: 14rem;
}
.calendar-parent {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    overflow-x: hidden;
    overflow-y: hidden;
    max-height: 80vh;
    background-color: white;
}
/* For long calendars, ensure each week gets sufficient height. The body of the calendar will scroll if needed */
.cv-wrapper.period-month.periodCount-2 .cv-week,
.cv-wrapper.period-month.periodCount-3 .cv-week,
.cv-wrapper.period-year .cv-week {
    min-height: 6rem;
}
/* These styles are optional, to illustrate the flexbility of styling the calendar purely with CSS. */
/* Add some styling for items tagged with the "birthday" class */
.theme-default .cv-item.birthday {
    background-color: #e0f0e0;
    border-color: #d7e7d7;
}
.theme-default .cv-item.birthday::before {
    content: "\1F382"; /* Birthday cake */
    margin-right: 0.5em;
}
/* The following classes style the classes computed in myDateClasses and passed to the component's dateClasses prop. */
.theme-default .cv-day.ides {
    background-color: #ffe0e0;
}
.ides .cv-day-number::before {
    content: "\271D";
}
.cv-day.do-you-remember.the-21st .cv-day-number::after {
    content: "\1F30D\1F32C\1F525";
}
</style>
