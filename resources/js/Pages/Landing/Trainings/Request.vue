<template>
    <landing>
        <template v-slot:main>
            <div class="trainings-single container margin-top-48">
                <div class="trainings-single__content">
                    <div class="trainings-single__left">
                        <div class="trainings-single__labels">
                            <div
                                class="label label--light-outline inline-flex items-center margin-bottom-16 padding-y-8"
                                v-if="item.phone">
                                {{ __('საკონტაქტო ნომერი') }}: {{ item.phone }}
                            </div>
                        </div>
                    </div>
                    <div class="trainings-single__right padding-left-134" v-if="item.pending">
                        <div class="width-452">
                            <h2>{{ __('მოთხოვნა გაგზავნილია. დაელოდეთ პასუხს') }}</h2>
                        </div>
                    </div>
                    <div class="trainings-single__right padding-left-134" v-else>
                        <div class="width-452">
                            <h2>{{ __('მოთხოვნა ტრენინგზე') }}</h2>
                            <p class="padding-top-34">{{ __('აირჩიეთ სასურველი პარამეტრები') }}</p>

                            <div v-if="form.errors">
                                <p class="padding-top-34" style="color: red">{{ form.errors.validation_error }}</p>
                            </div>
                            <div>
                                <p style="color: #88aa3f">{{ message }}</p>
                            </div>
                            <div
                                class="register__content margin-top-26"
                            >
                                <form
                                    class="form width-full"
                                    @submit.prevent="submit"
                                >
                                    <div class="form__group form__group--material margin-top-24">
                                        <c-input :id="'start_date'"
                                                 type="date"
                                                 class="form__element"
                                                 v-model="form.start_date"
                                                 :placeholder="__('სასურველი დღე')"/>
                                        <c-input-label :value="__('სასურველი დღე')"/>
                                        <c-input-error
                                            :message="form.errors.start_date"
                                            class="mt-2"/>
                                    </div>
                                    <div class="form__group form__group--material margin-top-24">
                                        <c-input :id="`maxPerson`"
                                                 type="number"
                                                 class="form__element"
                                                 v-model="form.max_person"
                                                 :placeholder="__('სასურველი ადგილი')"/>
                                        <c-input-label :value="__('სასურველი ადგილი')"/>
                                        <c-input-error
                                            :message="form.errors.max_person"
                                            class="mt-2"/>
                                    </div>

                                    <c-button
                                        class="button button--primary button--shadow button--border width-full margin-top-24"
                                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        {{ __('მოთხოვნის გაგზავნა') }}
                                    </c-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import CashIcon from "@/Components/Web/Icons/Cash";
import UserIcon from "@/Components/Web/Icons/User";
import UsersIcon from "@/Components/Web/Icons/Users";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import Drawer from "@/Components/Web/Drawer/Drawer";
import emitter from "@/Plugins/bus";
import SelectObject from "@/Components/Web/Select/SelectObject";
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CButton from "@/CoreUi/components/Button";
import CInputLabel from "@/CoreUi/components/InputLabel";

export default {
    components: {
        Button,
        Landing,
        Breadcrumb,
        CalendarIcon,
        CashIcon,
        UserIcon,
        UsersIcon,
        Drawer,
        SelectObject,
        CInputError,
        CInput,
        CButton,
        CInputLabel
    },
    props: {
        item: {
            type: Array
        },
        message: {
            type: String
        }
    },
    data() {
        return {
            form: this.$inertia.form({
                start_date: '',
                max_person: ''
            }),
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('trainings.request', this.item.slug), {
                onSuccess: () => setTimeout(() => {
                    location.reload()
                }, 1000),
            })
        },
    }
}
</script>
