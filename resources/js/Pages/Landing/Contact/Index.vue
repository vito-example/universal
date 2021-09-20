<template>
    <landing class="cotact">
        <template v-slot:main>
            <section class="contact_showcase margin_bottom" v-html="getValueByFields(contact.fields,'map_iframe')">
            </section>

            <section class="contant_page wrapper flex margin_bottom">
                <div>
                    <div class="main_titles">
                        <div class="title_bg bold">{{getValueByFields(contact.fields,'background_title')}}</div>
                        <div class="title bold main_blue">{{getValueByFields(contact.fields,'title')}}</div>
                    </div>
                    <div class="para" v-html="getValueByFields(contact.fields,'description')">

                    </div>
                    <div class="info_title medium">{{getValueByFields(contact.fields,'contact_sub_title')}}</div>
                    <a class="flex">
                        <img src="/landing_resources/img/icons/contact/1.png" alt=""/>
                        <div>
                            {{ getValueByFields(contact.fields, 'phone') }}
                        </div>
                    </a>
                    <a :href="'tel://' + getValueByFields(contact.fields,'phone')" class="flex">
                        <img src="/landing_resources/img/icons/contact/2.png" alt=""/>
                        <div>+995 555 555 555</div>
                    </a>
                    <a :href="'mailto:' + getValueByFields(contact.fields,'email')" class="flex">
                        <img src="/landing_resources/img/icons/contact/3.png" alt=""/>
                        <div>{{ getValueByFields(contact.fields, 'email') }}</div>
                    </a>
                    <div class="flex sm">
                        <template v-if="getValueByFields(social.fields, 'facebook')">
                            <a :href="getValueByFields(social.fields, 'email')" target="_blank"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <g
                                        id="Group_170"
                                        data-name="Group 170"
                                        transform="translate(-30.007 -127)"
                                    >
                                        <g
                                            id="Rectangle_89"
                                            data-name="Rectangle 89"
                                            transform="translate(30.007 127)"
                                            stroke="#707070"
                                            stroke-width="1"
                                            opacity="0"
                                        >
                                            <rect width="24" height="24" stroke="none"/>
                                            <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                        </g>
                                        <path
                                            id="Icon_awesome-facebook-f"
                                            data-name="Icon awesome-facebook-f"
                                            d="M9.652,9.943l.491-3.2H7.073V4.668a1.6,1.6,0,0,1,1.8-1.728h1.4V.216A17.018,17.018,0,0,0,7.8,0c-2.528,0-4.18,1.532-4.18,4.306V6.744H.8v3.2h2.81v7.734H7.073V9.943Z"
                                            transform="translate(36.07 129.946)"
                                        />
                                    </g>
                                </svg>
                            </a>
                        </template>
                        <template v-if="getValueByFields(social.fields, 'twitter')">
                            <a :href="getValueByFields(social.fields, 'twitter')" target="_blank"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <g
                                        id="Group_171"
                                        data-name="Group 171"
                                        transform="translate(-57 -127)"
                                    >
                                        <g
                                            id="Rectangle_90"
                                            data-name="Rectangle 90"
                                            transform="translate(57 127)"
                                            stroke="#707070"
                                            stroke-width="1"
                                            opacity="0"
                                        >
                                            <rect width="24" height="24" stroke="none"/>
                                            <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                        </g>
                                        <path
                                            id="Icon_ionic-logo-twitter"
                                            data-name="Icon ionic-logo-twitter"
                                            d="M17.412,3.861a6.929,6.929,0,0,1-1.968.542,3.439,3.439,0,0,0,1.508-1.9,6.81,6.81,0,0,1-2.177.832A3.426,3.426,0,0,0,8.845,5.68a3.355,3.355,0,0,0,.089.782A9.713,9.713,0,0,1,1.868,2.877,3.434,3.434,0,0,0,2.933,7.457a3.347,3.347,0,0,1-1.558-.428v.042a3.43,3.43,0,0,0,2.751,3.363,3.45,3.45,0,0,1-.9.12,3.233,3.233,0,0,1-.644-.064,3.433,3.433,0,0,0,3.2,2.382,6.872,6.872,0,0,1-4.259,1.469,6.947,6.947,0,0,1-.818-.05,9.58,9.58,0,0,0,5.246,1.551,9.694,9.694,0,0,0,9.76-9.763c0-.149,0-.3-.011-.443A6.977,6.977,0,0,0,17.412,3.861Z"
                                            transform="translate(60.321 129.785)"
                                        />
                                    </g>
                                </svg>
                            </a>
                        </template>
                        <template v-if="getValueByFields(social.fields, 'linkedin')">
                            <a :href="getValueByFields(social.fields, 'linkedin')" target="_blank"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <g
                                        id="Group_172"
                                        data-name="Group 172"
                                        transform="translate(-83 -127)"
                                    >
                                        <g
                                            id="Rectangle_91"
                                            data-name="Rectangle 91"
                                            transform="translate(83 127)"
                                            stroke="#707070"
                                            stroke-width="1"
                                            opacity="0"
                                        >
                                            <rect width="24" height="24" stroke="none"/>
                                            <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                        </g>
                                        <path
                                            id="Icon_awesome-linkedin-in"
                                            data-name="Icon awesome-linkedin-in"
                                            d="M3.525,15.75H.26V5.235H3.525ZM1.891,3.8A1.9,1.9,0,1,1,3.782,1.891,1.907,1.907,0,0,1,1.891,3.8ZM15.746,15.75H12.488V10.631c0-1.22-.025-2.784-1.7-2.784-1.7,0-1.958,1.325-1.958,2.7V15.75H5.571V5.235H8.7V6.669h.046a3.431,3.431,0,0,1,3.09-1.7c3.3,0,3.912,2.176,3.912,5V15.75Z"
                                            transform="translate(87 131)"
                                        />
                                    </g>
                                </svg>
                            </a>
                        </template>
                        <template v-if="getValueByFields(social.fields, 'youtube')">
                            <a :href="getValueByFields(social.fields, 'youtube')" target="_blank"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <g
                                        id="Group_173"
                                        data-name="Group 173"
                                        transform="translate(-115 -128)"
                                    >
                                        <g
                                            id="Rectangle_92"
                                            data-name="Rectangle 92"
                                            transform="translate(115 128)"
                                            stroke="#707070"
                                            stroke-width="1"
                                            opacity="0"
                                        >
                                            <rect width="24" height="24" stroke="none"/>
                                            <rect x="0.5" y="0.5" width="23" height="23" fill="none"/>
                                        </g>
                                        <path
                                            id="Icon_ionic-logo-youtube"
                                            data-name="Icon ionic-logo-youtube"
                                            d="M17.94,5.241a2.742,2.742,0,0,0-2.61-2.864c-1.954-.092-3.947-.127-5.982-.127H8.712c-2.032,0-4.028.035-5.982.127A2.748,2.748,0,0,0,.123,5.248C.035,6.5,0,7.76,0,9.015s.035,2.511.12,3.771a2.751,2.751,0,0,0,2.607,2.875c2.053.1,4.159.138,6.3.134s4.243-.035,6.3-.134a2.752,2.752,0,0,0,2.61-2.875c.085-1.259.123-2.515.12-3.774S18.024,6.5,17.94,5.241ZM7.3,12.476V5.544l5.115,3.464Z"
                                            transform="translate(118.01 130.767)"
                                        />
                                    </g>
                                </svg>
                            </a>
                        </template>
                    </div>
                </div>
                <form @submit.prevent="submit" class="form">
                    <div class="title medium">{{getValueByFields(contact.fields,'form_title')}}</div>
                    <div class="grid">
                        <div class="input border">
                            <label for="">{{__('First name')}}</label>
                            <input v-model="form.first_name" required type="text" :placeholder="__('Enter your name')"/>
                        </div>
                        <div class="input border">
                            <label for="">{{__('First name')}}</label>
                            <input v-model="form.last_name" required type="text" :placeholder="__('Enter your name')"/>
                        </div>
                        <div class="input border">
                            <label for="">{{__('Mobile Number')}}</label>
                            <input v-model="form.phone" required type="number" :placeholder="__('Enter your phone')"/>
                        </div>
                        <div class="input border">
                            <label for="">{{__('Email')}}</label>
                            <input v-model="form.email" required type="email" :placeholder="__('Enter your email')"/>
                        </div>
                    </div>
                    <div class="input">
                        <label for="">{{__('Mesage')}}</label>
                        <textarea required v-model="form.message" class="border" :placeholder="__('Enter message')"></textarea>
                    </div>
                    <button class="main_btn">{{__('Send Messages')}}</button>
                </form>
            </section>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";

export default {
    components: {
        Landing,
    },
    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                phone: '',
                email: '',
                message: ''
            })
        }
    },
    computed: {
        contact() {
            return this.$page.props.layoutData ? this.$page.props.layoutData.contact : {}
        },
        social() {
            return this.$page.props.layoutData ? this.$page.props.layoutData.social : {}
        },
    },
    methods: {
        submit() {
            this.form.post(this.route('contact.send'), {
                onSuccess: () => this.form.reset()
            })
        },
        getValueByFields(fields, key) {
            if (!fields[key]) {
                return ''
            }
            return fields[key].value
        }
    },
    mounted() {
        console.log(12345)
    }

}
</script>
