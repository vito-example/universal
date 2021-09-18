<template>
    <footer class="footer">
        <div class="wrapper flex">
            <div class="column">
                <inertia-link :href="route('home.index')" class="logo medium">
                    {{__('UNIVERSAL')}} <span>{{__('PROJECT')}}</span>

                </inertia-link>
                <div class="poppins">
                    Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text
                    ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book. It has survived not
                    only five centuries,
                </div>
                <div class="item time flex">
                    <img src="/landing_resources/img/icons/header/4.png" alt="" />
                    <div style="text-transform: uppercase">
                        {{ getValueByFields(contact.fields, 'working') }}
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="title bold">Our Services</div>
                <a class="item link" href="#">Chemical Engineering Projects</a>
                <a class="item link" href="#">Mining Engineering Construction</a>
                <a class="item link" href="#">Engineering Welding Engineering</a>
                <a class="item link" href="#">Welding Engineering</a>
                <a class="item link" href="#">Space Program XYZ</a>
            </div>
            <div class="column">
                <div class="title bold">{{__('Office in Tbilisi')}}</div>
                <a class="item flex">
                    <img src="/landing_resources/img/icons/header/2.png" alt="" />
                    <div>
                        {{ getValueByFields(contact.fields,'address') }}
                    </div>
                </a>
                <a :href="'tel://' + getValueByFields(contact.fields,'phone')" class="item flex">
                    <img src="/landing_resources/img/icons/header/1.png" alt="" />
                    <div>
                        {{ getValueByFields(contact.fields,'phone') }}
                    </div>
                </a>
                <a :href="'mailto:' + getValueByFields(contact.fields,'email')" class="item flex">
                    <img src="/landing_resources/img/icons/header/3.png" alt="" />
                    <div>
                        {{getValueByFields(contact.fields,'email')}}
                    </div>
                </a>
            </div>
            <div class="column">
                <div class="title bold">{{__('Our Locations')}}</div>
                <div class="map" v-html="getValueByFields(contact.fields,'map_iframe')">

                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="wrapper bold poppins">{{__('By insite')}}</div>
        </div>
    </footer>

</template>

<script>

export default {
    name: "Footer",
    components: {
    },
    computed: {
        contact () {
            return this.$page.props.layoutData ? this.$page.props.layoutData.contact : {}
        },
        social () {
            return this.$page.props.layoutData ? this.$page.props.layoutData.social : {}
        },
    },
    methods: {
        getValueByFields (fields, key) {
            if (!fields[key]) {
                return ''
            }
            return fields[key].value
        }
    },
}
</script>
