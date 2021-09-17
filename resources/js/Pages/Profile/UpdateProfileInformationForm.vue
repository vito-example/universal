<template>
    <div>
        <c-card>
            <template v-slot:header>
                {{ __('Profile information') }}
            </template>
            <template v-slot:body>
<!--                <c-validation-errors/>-->
                <form @submit.prevent="updateProfileInformation">

                    <c-input-label for="phone_number" :value="__('Profile Photo')"/>

                    <div class="form-group">

                        <input type="file" class="hidden"
                               ref="photo"
                               @change="updatePhotoPreview" accept="image/*">

                        <div class="my-4" v-show="! photoPreview && user.profile_photo_url">
                            <img :src="user.profile_photo_url" :alt="user.name"
                                 class="rounded-full h-20 w-20 object-cover mb-4">
                        </div>

                        <!-- New Profile Photo Preview -->
                        <div class="my-4" v-show="photoPreview">
                            <span class="block rounded-full w-20 h-20"
                                  :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>

                        <c-button
                            :disabled="isDisableInput"
                            @click.prevent="selectNewPhoto"
                            class="btn btn-secondary font-weight-bold"
                            type="button">
                            {{ __('Select a new profile photo') }}
                        </c-button>

                        <c-input-error :message="form.errors.photo" class="mt-2"/>
                    </div>

                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="name" :value="__('Name')"/>
                            <c-input :disabled="isDisableInput" @keypress="isLatinAlphabet($event)"
                                     id="name" type="text" v-model="form.name" autofocus>
                            </c-input>
                            <c-input-error :message="form.errors.name" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="surname" :value="__('Surname')"/>
                            <c-input :disabled="isDisableInput" @keypress="isLatinAlphabet($event)"
                                     id="surname" type="text" v-model="form.surname" autofocus>
                            </c-input>
                            <c-input-error :message="form.errors.surname" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="citizenship_id" :value="__('Citizenship')"/>
                            <c-select
                                :disabled="isDisableInput"
                                id="citizenship_id"
                                :options="citizenship"
                                :value="form.citizenship_id"
                                :placeholder="__('Citizenship')"
                                v-model="form.citizenship_id"
                                ref="citizenship_id"
                                class="block w-full"/>
                            <c-input-error :message="form.errors.citizenship_id" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="personal_number" :value="__('Personal Number')"/>
                            <c-input :disabled="isDisableInput" @keypress="digitNumber($event,form.personal_number,11)"
                                     id="personal_number" type="text" v-model="form.personal_number" autofocus>
                            </c-input>
                            <c-input-error :message="form.errors.personal_number" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="activity_id" :value="__('Activity')"/>
                            <c-select
                                :disabled="isDisableInput"
                                id="activity_id"
                                :options="activities"
                                v-model="form.activity_id"
                                :value="form.activity_id"
                                :placeholder="__('Activity')"
                                @change="updateActivity($event)"
                                ref="activity_id"
                                class="block w-full"/>
                            <c-input-error :message="form.errors.activity_id" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="doctor_types" :value="__('Doctor Type')"/>
                            <Multiselect
                                :noResultsText="__('Select no result found')"
                                :disabled="isDisableInput"
                                id="doctor_types"
                                :placeholder="__('Doctor Type')"
                                mode="tags"
                                :searchable="true"
                                v-model="form.doctor_types"
                                :options="doctorTypes"/>
                            <c-input-error :message="form.errors.doctor_types" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6" v-if="showActivityVerifyId">
                            <c-input-label for="activity_verify_id" :value="__('Activity verify id')"/>
                            <c-input id="activity_verify_id" type="text" v-model="form.activity_verify_id" :disabled="isDisableInput" autofocus></c-input>
                            <c-input-error :message="form.errors.activity_verify_id" class="mt-2"/>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <c-input-label for="phone_number" :value="__('Phone Number')"/>

                            <div class="form-row">
                                <div class="form-group col-4">
                                    <c-select
                                        :disabled="isDisableInput"
                                        @change="changeSelect($event,'phone_prefix')"
                                        id="phone_prefix"
                                        :options="prefixes"
                                        v-model="form.phone_prefix"
                                        ref="phone_prefix"
                                        class="block w-full"/>
                                </div>
                                <div class="form-group col-8">
                                    <c-input :disabled="isDisableInput" @keypress="isGeorgianPhoneNumber($event,form.phone_number)"
                                             :placeholder="__('Phone placeholder')"
                                             id="phone_number" type="text" v-model="form.phone_number" autofocus>
                                    </c-input>
                                </div>
                                <c-input-error :message="form.errors.phone_number" class="mt-2"/>
                            </div>
                        </div>
                    </div>

                    <c-action-message
                        :on="form.recentlySuccessful">
                        {{ __('Saved profile information') }}
                    </c-action-message>
                    <c-button
                        v-if="!isDisableInput"
                        class="btn btn-success px-4 font-weight-bold"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        {{ __('Save') }}
                    </c-button>
                    <c-button
                        v-if="isDisableInput"
                        @click.prevent="toggleInputDisable"
                        class="btn btn-info px-4 font-weight-bold"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        {{ __('Edit Profile Data') }}
                    </c-button>
                    <inertia-link :href="route('profile.show')" v-else>
                        <c-button
                            class="btn btn-danger ml-3 px-4 font-weight-bold">
                            {{ __('Canceled Profile Data Update') }}
                        </c-button>
                    </inertia-link>
                </form>


            </template>
        </c-card>
    </div>
</template>

<script>
import NSelect from "@/Components/Select";
import CCard from "@/CoreUi/components/Card";
import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CValidationErrors from "@/CoreUi/components/ValidationErrors";
import CButton from "@/CoreUi/components/Button";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CSelect from "@/CoreUi/components/Select";
import CCheckbox from "@/CoreUi/components/Checkbox";
import CActionMessage from "@/CoreUi/components/ActionMessage";
import Authenticate from "@/Layouts/Authenticate";
import Multiselect from "@vueform/multiselect";

export default {
    components: {
        NSelect,
        CSuccessLabel,
        Authenticate,
        CInput,
        CInputError,
        CValidationErrors,
        CButton,
        CInputLabel,
        CSelect,
        CCheckbox,
        CCard,
        CActionMessage,
        Multiselect
    },

    props: {
        user: {
            required: true,
            type: Object,
        },
        options: {
            required: true,
            type: Object,
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                photo: null,
                name: this.user.name,
                surname: this.user.surname,
                citizenship_id: this.user.citizenship_id,
                personal_number: this.user.personal_number,
                passport_number: this.user.passport_number,
                activity_id: this.user.activity_id,
                activity_verify_id: this.user.activity_verify_id,
                phone_prefix: this.user.phone_prefix,
                phone_number: this.user.phone_number,
                password: this.user.password,
                password_confirmation: this.user.password_confirmation,
                terms: this.user.terms,
                advertisement: this.user.advertisement,
                doctor_types: this.user.doctor_types,
            }),
            photoPreview: null,
            isDisableInput: true,
            showActivityVerifyId: false,
            activityHardIds: [5, 6, 7]
        }
    },
    computed: {
        activities() {
            return this.options ? this.options.activities : []
        },
        citizenship() {
            return this.options ? this.options.citizenship : []
        },
        prefixes() {
            return this.options ? this.options.prefixes : []
        },
        doctorTypes() {
            return this.options ? this.options.doctor_types : []
        }
    },
    methods: {
        toggleInputDisable () {
            this.isDisableInput = !this.isDisableInput
        },
        changeSelect(event, fieldKey, subKey = null) {
            if (subKey !== null) {
                this.form[fieldKey][subKey] = event.target.value
            } else {
                this.form[fieldKey] = event.target.value
            }
        },
        updateProfileInformation() {
            this.$page.props.errors = {}
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onFinish: () => {
                    if (!Object.keys(this.$page.props.errors).length) {
                        this.toggleInputDisable()
                    }
                },
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },
        updateActivity(e) {
            const value = e ? e.target.value : this.form.activity_id;

            this.showActivityVerifyId = this.activityHardIds.includes(Number(value));
        },
        deletePhoto() {
            this.$inertia.delete(route('current-user-photo.destroy'), {
                preserveScroll: true,
                onSuccess: () => (this.photoPreview = null),
            });
        },
    },

    mounted() {
        this.updateActivity()
    }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
