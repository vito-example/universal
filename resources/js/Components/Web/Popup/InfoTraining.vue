<template>
    <popup
        v-if="visible"
        :title="`${__('ტრენინგის დეტალები')}`"
    >
        <div class="margin-top-16">
            <h5>{{ __('დეტალები') }}</h5>
        </div>
        <div class="margin-top-16">
            <p>{{ __('თარიღი') }}: {{ session.start_time }}</p>
        </div>
        <div class="margin-top-16">
            <p>{{ __('დრო') }}: {{ session.start_time_hour }} {{ __('-დან') }} {{ session.end_time_hour }}
                {{ __('-მდე') }}</p>
        </div>
        <div class="margin-top-16">
            <p>{{ __('ხანგძლივობა') }}: {{ session.duration / 60 }} {{ __('საათი') }}</p>
        </div>
        <div class="margin-top-16">
            <h5>{{ __('ტრენინგის ჩატარების ადგილი') }}</h5>
        </div>
        <div class="margin-top-16" v-if="session.form === 'online'">
            <p>{{ __('იხილეთ ონლაინ ტრენინგის ლინკი') }} <a :href="session.link" style="color: #E49540" :disabled="link ? 'disabled' : ''">{{ __('ლინკი') }}</a>
            </p>
        </div>
        <div class="margin-top-16" v-else-if="session.form === 'offline'">
            <p>{{ session.place }}</p>
        </div>
        <div class="margin-top-16">
            <h5>{{ __('ტრენინგზე დარეგისტრირებული მომხმარებელი') }}</h5>
        </div>
        <div class="margin-top-16" v-if="session.attendees_user.length" v-for="(item,index) in session.attendees_user">
            <p>{{ item.label }}</p>
        </div>
        <div class="margin-top-16" v-else>
            <p>{{ __('მომხმარებელი არ მოიძებნა') }}</p>
        </div>
        <div class="margin-top-16">
            <h5>{{ __('ტრენინგზე დარეგისტრირებული თანამშრომლები') }}</h5>
        </div>
        <div class="margin-top-16" v-if="session.attendees_employee.length"
             v-for="(item,index) in session.attendees_employee">
            <p>{{ item.label }}</p>
        </div>
        <div class="margin-top-16" v-else>
            <p>{{ __('თანამშრომელი არ მოიძებნა') }}</p>
        </div>
    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";

export default {
    components: {
        Popup,
    },

    data() {
        return {
            session: {},
            visible: false,
        }
    },
    methods: {
        link(item) {
            let now = new Date('YYYY-MM-DD HH:mm:ss');
            if (now > item.start_date && now < item.end_date && item.link) return false;
            return true;
        },
    },

    mounted() {
        emitter.on('showInfoTrainingPopup', (session) => {
            this.session = session;
            this.visible = true;
        })
    }
}
</script>
