<template>
    <div class="custom-select" @blur="open = false">
      <div class="selected" :class="{ open: open }" @click="open = !open">
        {{ __('გამარჯობა') }}, <strong>{{selected}}</strong>
      </div>
      <div class="items" :class="{ selectHide: !open }">
        <div>
          <Link class="flex items-center" :href="route('profile.show')">
            <svg width="23" height="23" class="margin-right-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M8.75 7C8.75 5.20507 10.2051 3.75 12 3.75C13.7949 3.75 15.25 5.20507 15.25 7C15.25 8.79493 13.7949 10.25 12 10.25C10.2051 10.25 8.75 8.79493 8.75 7ZM12 2.25C9.37665 2.25 7.25 4.37665 7.25 7C7.25 9.62335 9.37665 11.75 12 11.75C14.6234 11.75 16.75 9.62335 16.75 7C16.75 4.37665 14.6234 2.25 12 2.25ZM5.75 19C5.75 17.2051 7.20507 15.75 9 15.75L15 15.75C16.7949 15.75 18.25 17.2051 18.25 19C18.25 19.6904 17.6904 20.25 17 20.25L7 20.25C6.30964 20.25 5.75 19.6904 5.75 19ZM9 14.25C6.37665 14.25 4.25 16.3766 4.25 19C4.25 20.5188 5.48122 21.75 7 21.75L17 21.75C18.5188 21.75 19.75 20.5188 19.75 19C19.75 16.3766 17.6234 14.25 15 14.25L9 14.25Z" fill="currentColor"/>
            </svg>

            პროფილი
          </Link>
        </div>
        <div>
          <Link class="flex items-center" :href="route('logout')">
            <svg width="24" height="22" class="margin-right-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 2.25H10.4548C9.3204 2.24999 8.40571 2.24997 7.67622 2.33221C6.92195 2.41725 6.27343 2.59807 5.71714 3.02493C5.45715 3.22443 5.22443 3.45715 5.02493 3.71714C4.59807 4.27343 4.41725 4.92195 4.33221 5.67622C4.24997 6.40571 4.24999 7.3204 4.25 8.45481V8.5L4.25 15.5L4.25 15.5452C4.24999 16.6796 4.24997 17.5943 4.33221 18.3238C4.41725 19.0781 4.59807 19.7266 5.02493 20.2829C5.22443 20.5429 5.45715 20.7756 5.71714 20.9751C6.27343 21.4019 6.92195 21.5828 7.67622 21.6678C8.40571 21.75 9.32039 21.75 10.4548 21.75H10.5H11C11.4142 21.75 11.75 21.4142 11.75 21C11.75 20.5858 11.4142 20.25 11 20.25H10.5C9.30977 20.25 8.47987 20.2489 7.84426 20.1772C7.22376 20.1073 6.88193 19.9781 6.63029 19.785C6.47429 19.6653 6.33466 19.5257 6.21496 19.3697C6.02187 19.1181 5.89272 18.7762 5.82277 18.1557C5.75112 17.5201 5.75 16.6902 5.75 15.5L5.75 8.5C5.75 7.30977 5.75112 6.47987 5.82277 5.84426C5.89272 5.22376 6.02187 4.88193 6.21496 4.63029C6.33466 4.47429 6.47429 4.33466 6.63029 4.21496C6.88193 4.02187 7.22376 3.89272 7.84426 3.82277C8.47987 3.75112 9.30977 3.75 10.5 3.75H11C11.4142 3.75 11.75 3.41421 11.75 3C11.75 2.58579 11.4142 2.25 11 2.25H10.5ZM16.5303 7.46967C16.2374 7.17678 15.7626 7.17678 15.4697 7.46967C15.1768 7.76256 15.1768 8.23744 15.4697 8.53033L18.1893 11.25H11C10.5858 11.25 10.25 11.5858 10.25 12C10.25 12.4142 10.5858 12.75 11 12.75H18.1893L15.4697 15.4697C15.1768 15.7626 15.1768 16.2374 15.4697 16.5303C15.7626 16.8232 16.2374 16.8232 16.5303 16.5303L20.5303 12.5303C20.8232 12.2374 20.8232 11.7626 20.5303 11.4697L16.5303 7.46967Z" fill="currentColor"/>
            </svg>

            გამოსვლა
          </Link>
        </div>
      </div>
    </div>
    <!--<div class="custom-dropdown" :tabindex="tabindex" @blur="open = false">
        <div class="selected" :class="{ open: open }" @click="open = !open">
            {{ __('გამარჯობა') }}, <strong>{{selected}}</strong>
        </div>
        <div class="items" :class="{ selectHide: !open }">
            <div
                v-for="(option, i) of options"
                :key="i"
            >
                <Link class="nav__link" v-bind:class="{ flex: option.icon,'items-center': option.icon }" :href="route(option.route)">
                    <template v-if="option.icon">
                        <user-icon width="24" class="margin-right-8" height="24" v-if="option.icon === 'user'"/>
                        <logout-icon width="24" class="margin-right-8" height="24" v-if="option.icon === 'logout'"/>
                    </template>
                    {{ __(getOption(option)) }}
                </Link>
            </div>
        </div>
    </div>-->
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import UserIcon from "@/Components/Web/Icons/User";
import LogoutIcon from "@/Components/Web/Icons/Logout";

export default {
    components: {
        Link,
        UserIcon,
        LogoutIcon
    },
    props: {
        options: {
            type: Array,
            required: true,
        },
        default: {
            type: String,
            required: false,
            default: null,
        },
    },
    data() {
        return {
            selected: this.default,
            open: false,
        };
    },
    methods: {
        getOption(option) {
            if (option.label === undefined) {
                return option;
            }
            return option.label
        }
    },

    mounted() {
      console.log(this.options)
    }
};
</script>
