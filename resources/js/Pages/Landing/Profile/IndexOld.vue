<template>
    <landing>
        <template v-slot:main>
            <div class="container">
                <h1 class="font-size-xl font-weight-600 margin-top-20">{{ __('გამარჯობა') }}, ირაკლი</h1>

                <div class="tab margin-top-10">
                    <ul class="nav nav--horizontal nav--tabs">
                        <li class="nav__item" :class="{ 'is-active': activeTab === 'trainings' }">
                            <a href="#" class="nav__link" title="უსაფრთხოება" @click="setActiveTab('trainings')">
                                {{ __('ჩემი ტრენინგები') }}
                            </a>
                        </li>
                        <li class="nav__item" :class="{ 'is-active': activeTab === 'companies' }">
                            <a href="#" class="nav__link" title="ჩემი კომპანიები" @click="setActiveTab('companies')">
                                {{ __('ჩემი კომპანიები') }}
                            </a>
                        </li>
                        <li class="nav__item" :class="{ 'is-active': activeTab === 'colleagues' }">
                            <a href="#" class="nav__link" title="ჩემი თანამშრომლები"
                               @click="setActiveTab('colleagues')">{{ __('ჩემი თანამშრომლები') }}</a>
                        </li>
                        <li class="nav__item" :class="{ 'is-active': activeTab === 'personal' }">
                            <a href="#" class="nav__link" title="პირადი ინფორმაცია" @click="setActiveTab('personal')">
                                {{ __('პირადი ინფორმაცია') }}
                            </a>
                        </li>
                        <li class="nav__item" :class="{ 'is-active': activeTab === 'security' }">
                            <a href="#" class="nav__link" title="უსაფრთხოება" @click="setActiveTab('security')">
                                {{ __('უსაფრთხოება') }}
                            </a>
                        </li>
                    </ul>

                    <div v-show="activeTab === 'personal'" class="tab__content is-active">
                        <form
                            class="form width-416"
                            @submit.prevent="submitProfile"

                        >
                            <div class="form__group form__group--material">
                                <c-input id="name" type="text" v-model="profile.name"
                                         :placeholder="__('სახელი')"/>
                                <c-input-label for="name" :value="__('სახელი')"/>
                                <c-input-error :message="profile.errors.name" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input id="surname" type="text" v-model="profile.surname"
                                         :placeholder="__('გვარი')"/>
                                <c-input-label for="surname" :value="__('გვარი')"/>
                                <c-input-error :message="profile.errors.surname" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input type="email" v-model="profile.email"
                                         :placeholder="__('მეილი')"/>
                                <c-input-label for="email" :value="__('მეილი')"/>
                                <c-input-error :message="profile.errors.email" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input id="mobileNumber" type="text"
                                         v-model="profile.phone_number"
                                         :placeholder="__('ტელეფონი')"/>
                                <c-input-label for="mobileNumber" :value="__('ტელეფონი')"/>
                                <c-input-error :message="profile.errors.phone_number" class="mt-2"/>
                            </div>
                            <c-button
                                class="button button--primary button--shadow button--border width-full margin-top-24"
                                :class="{ 'opacity-25': profile.processing }" :disabled="profile.processing">
                                {{ __('მონაცემების შენახვა') }}
                            </c-button>
                        </form>
                    </div>

                    <div v-show="activeTab === 'companies'" class="tab__content is-active">
                        <div class="profile__list width-416">
                            <div class="flex space-between margin-bottom-28" v-for="(company,index) in companies"
                                 v-if="companies.length">
                                <div>
                                    {{ company.title }}
                                </div>

                                <div>
                                    <button
                                        type="button"
                                        class="button button--link color-black text-decoration-none"
                                        @click="handleShowEditCompany(company)"

                                    >
                                        <edit-icon width="24" height="24"/>
                                    </button>

                                    <button
                                        type="button"
                                        class="button button--link color-black text-decoration-none margin-left-16"
                                        @click="handleShowDeletePopup(route('company.destroy',company.id))"
                                    >
                                        <delete-icon width="24" height="24"/>
                                    </button>
                                </div>
                            </div>
                            <div class="flex space-between margin-bottom-28" v-else>
                                <div>
                                    {{ __('კომპანია არ მოიძებნა') }}
                                </div>
                            </div>

                            <hr>

                            <button
                                type="button"
                                class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                                @click="handleShowNewCompany"
                            >
                                {{ __('ახალი კომპანიის დამატება') }}
                            </button>

                        </div>
                    </div>

                    <div v-show="activeTab === 'colleagues'" class="tab__content is-active">
                        <div class="profile__list width-416">
                            <vue-collapsible-panel-group
                                v-if="companies.length"
                                base-color="#9DBF53"
                            >
                                <vue-collapsible-panel :expanded="false" v-for="(company,index) in companies" v-if="!!companies"
                                                       :key="`panel-${index}`">
                                    <template #title>
                                        <p
                                            class="color-black font-size-sm"
                                        >
                                                        <span>
                                                            {{ company.title }}
                                                        </span>
                                        </p>
                                    </template>
                                    <template #content>
                                        <div v-for="(employee,index) in company.employees"
                                             v-if="company.employees.length"
                                             :key="`employee-${index}-${employee.name}`"
                                             class="flex space-between margin-bottom-28">
                                            <div>
                                                {{ employee.name }}
                                            </div>

                                            <div>
                                                <button
                                                    type="button"
                                                    class="button button--link color-black text-decoration-none"
                                                    @click="handleShowEditColleague(employee)"

                                                >
                                                    <edit-icon width="24" height="24"/>
                                                </button>

                                                <button
                                                    type="button"
                                                    class="button button--link color-black text-decoration-none margin-left-16"
                                                    @click="handleShowDeletePopup(route('employee.destroy',employee.id))"
                                                >
                                                    <delete-icon width="24" height="24"/>
                                                </button>
                                            </div>
                                        </div>
                                        <div v-else class="flex space-between margin-bottom-28">
                                            <div>
                                                {{ __('თანამშრომელი არ მოიძებნა') }}
                                            </div>

                                        </div>

                                    </template>
                                </vue-collapsible-panel>
                            </vue-collapsible-panel-group>
                            <div v-else>
                                {{ __('თანამშრომელი არ მოიძებნა') }}
                            </div>
                            <hr>

                            <button
                                type="button"
                                v-if="companies.length"
                                class="button button--link color-black font-size-xs font-weight-600 text-decoration-none block margin-top-24"
                                @click="handleShowNewColleague"
                            >
                                {{ __('ახალი თანამშრომლის დამატება') }}
                            </button>

                        </div>
                    </div>

                    <div v-show="activeTab === 'security'" class="tab__content is-active">
                        <form
                            class="form width-416"
                            @submit.prevent="submitPassword"

                        >
                            <div class="form__group form__group--material">
                                <c-input type="password" v-model="password.current_password"
                                         :placeholder="__('არსებული პაროლი')"/>
                                <c-input-label for="email" :value="__('არსებული პაროლი')"/>
                                <c-input-error :message="password.errors.current_password" class="mt-2"/>
                                <c-input-error
                                    :message="password.errors.updatePassword ? password.errors.updatePassword.current_password : ''"
                                    class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input type="password" v-model="password.password"
                                         :placeholder="__('ახალი პაროლი')"/>
                                <c-input-label for="email" :value="__('ახალი პაროლი')"/>
                                <c-input-error :message="password.errors.password" class="mt-2"/>
                            </div>

                            <div class="form__group form__group--material margin-top-16">
                                <c-input type="password" v-model="password.password_confirmation"
                                         :placeholder="__('გაიმეორეთ პაროლი')"/>
                                <c-input-label for="email" :value="__('გაიმეორეთ პაროლი')"/>
                                <c-input-error :message="password.errors.password_confirmation" class="mt-2"/>
                            </div>

                            <c-button
                                class="button button--primary button--shadow button--border width-full margin-top-24"
                                :class="{ 'opacity-25': profile.processing }" :disabled="profile.processing">
                                {{ __('პაროლის განახლება') }}
                            </c-button>
                        </form>
                    </div>

                    <div v-show="activeTab === 'trainings'" class="tab__content is-active">
                        <div class="width-600">
                            <div class="flex items-center space-between margin-top-34"
                                 v-for="(training,index) in trainings" v-if="trainings.length">
                                <div>
                                    <div class="font-weight-600">{{training.title}}</div>

                                    <div class="flex margin-top-18">
                                        <div
                                            v-if="training.form === 'online'"
                                            class="label label--light-outline border-color-middle-green-yellow color-middle-green-yellow flex items-center">
                                            <div class="label__icon line-height-0 padding-right-8">
                                                <video-icon width="16" height="16"/>
                                            </div>

                                            {{__('Online')}}
                                        </div>
                                        <div class="label label--light-outline flex items-center"
                                             v-bind:class="{ 'margin-left-12': training.form ==='online' }">
                                            <div class="label__icon line-height-0 padding-right-8">
                                                <calendar-icon width="16" height="16"/>
                                            </div>

                                            {{ training.start_time }} {{training.start_time_hour}} {{__('სთ')}}
                                        </div>
                                        <div class="flex items-center margin-left-12 cursor-pointer">
                                            <a @click="handleShowInfoTraining(training)">
                                                <span><alert-icon width="24" height="24"/></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="training.form === 'online'">
                                    <a :href="training.link"
                                       target="_blank"
                                       class="button button--primary button--border text-center"
                                       :class="{'is-disabled': isActive(training)}">
                                        {{ __('ტრენინგის ლინკი') }}
                                    </a>
                                </div>
                                <div v-else-if="training.place">
                                    <a href="" disabled
                                       class="button button--primary is-disabled button--border text-center">
                                       <span>
                                           <location-icon width="16" height="16"/>
                                       </span>
                                        {{ training.place }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <new-company-popup/>
            <edit-company-popup/>
            <new-colleague-popup/>
            <edit-colleague-popup/>
            <delete-popup/>
            <info-popup/>
        </template>
    </landing>
</template>
<script>
import emitter from "@/Plugins/bus";
import Landing from "@/Layouts/Landing";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import Drawer from "@/Components/Web/Drawer/Drawer";
import EditIcon from "@/Components/Web/Icons/Edit";
import DeleteIcon from "@/Components/Web/Icons/Delete";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import AlertIcon from "@/Components/Web/Icons/Alert";
import DeletePopup from "@/Components/Web/Popup/Delete";
import InfoPopup from "@/Components/Web/Popup/InfoTraining";
import NewCompanyPopup from "@/Components/Web/Popup/NewCompany";
import EditCompanyPopup from "@/Components/Web/Popup/EditCompany";
import NewColleaguePopup from "@/Components/Web/Popup/NewColleague";
import EditColleaguePopup from "@/Components/Web/Popup/EditColleague";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CButton from "@/CoreUi/components/Button";
import {
    VueCollapsiblePanelGroup,
    VueCollapsiblePanel,
} from '@dafcoe/vue-collapsible-panel'
import '@dafcoe/vue-collapsible-panel/dist/vue-collapsible-panel.css'
import LocationIcon from "@/Components/Web/Icons/Location";


export default {
    components: {
        Landing,
        Breadcrumb,
        Drawer,
        EditIcon,
        DeleteIcon,
        NewCompanyPopup,
        EditCompanyPopup,
        DeletePopup,
        NewColleaguePopup,
        EditColleaguePopup,
        CInput,
        CInputError,
        CInputLabel,
        CButton,
        VueCollapsiblePanelGroup,
        VueCollapsiblePanel,
        LocationIcon,
        InfoPopup,
        CalendarIcon,
        AlertIcon
    },
    props: {
        user: {
            type: Array
        },
        companies: {
            type: Array
        },
        trainings: {
            type: Array
        },
        tab: {
            type: String
        }
    },
    data() {
        return {
            activeTab: this.tab ?? 'trainings',
            profile: this.$inertia.form({
                name: this.user.name ?? '',
                surname: this.user.surname ?? '',
                email: this.user.email ?? '',
                phone_number: this.user.phone_number ?? '',
            }),
            password: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: '',
            }),
            companies: this.companies ?? [],
            trainings: this.trainings ?? [],
            renderEmployee: true,
        }
    },
    watch: {
        'companies'(value) {
            this.companies = value;
            // Remove my-component from the DOM
            // this.renderEmployee = false;
            //
            // this.$nextTick(() => {
            //     // Add the component back in
            //     this.renderEmployee = true;
            // });
        },
    },
    methods: {
        isActive(item) {
            let now = new Date('YYYY-MM-DD HH:mm:ss');
            if (now > item.start_date && now < item.end_date && item.link) return false;
            return true;
        },
        submitProfile() {
            this.profile.put(this.route('user-profile-information.update'), {
                onFinish: () => console.log('updated'),
            })
        },
        submitPassword() {
            this.password.put(this.route('user-password.update'), {
                onFinish: () => console.log('updated'),
            })
        },
        setActiveTab(name) {
            this.activeTab = name
        },

        handleShowNewCompany() {
            emitter.emit('showNewCompanyPopup')
        },
        handleShowInfoTraining(training) {
            emitter.emit('showInfoTrainingPopup', training)
        },

        handleShowEditCompany(company) {
            emitter.emit('showEditCompanyPopup', company)
        },

        handleShowDeletePopup(route) {
            emitter.emit('showDeletePopup', route)
        },

        handleShowNewColleague() {
            emitter.emit('showNewColleaguePopup', this.companies)
        },

        handleShowEditColleague(employee) {
            emitter.emit('showEditColleaguePopup', {
                employee: employee,
                companies: this.companies
            })
        },

        handleShowTrainer() {
            emitter.emit('showDrawer')
        }
    }
}
</script>
