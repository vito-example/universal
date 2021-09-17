<template>
    <div>
        <c-success-label :status="status"></c-success-label>
        <c-card class="card-accent-primary">
            <template v-slot:header>
                {{ __('Manage Company') }}
            </template>
            <template v-slot:body>

                    <c-input-label for="phone_number" :value="__('Profile Photo')"/>
                    <div class="form-group">
                        <input type="file" class="hidden"
                               :disabled="isDisableInput"
                               accept="image/*"
                               ref="photo">

                        <div class="my-4" v-show="! photoPreview" v-if="item && item.image_url">
                            <img :src="item.image_url" :alt="item.title"
                                 class="rounded-full h-20 w-20 object-cover">
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
                        <div class="form-group col-6">
                            <c-input-label for="name" :value="__('Company title')"/>
                            <c-input :disabled="isDisableInput"  id="name" type="text" v-model="form.title" autofocus>
                            </c-input>
                            <c-input-error :message="form.errors.title" class="mt-2"/>
                        </div>

                        <div class="form-group col-6">
                            <c-input-label for="identity_id" :value="__('Company identity id')"/>
                            <c-input  @keypress="isNumberValidate($event)" :disabled="isDisableInput"  id="identity_id" type="text" v-model="form.identity_id" autofocus>
                            </c-input>
                            <c-input-error :message="form.errors.identity_id" class="mt-2"/>
                        </div>
                    </div>

<!--                    <div class="form-group">-->
<!--                        <c-input-label for="description" :value="__('Company description')"/>-->
<!--                        <c-textarea id="description" type="text" v-model="form.description" autofocus></c-textarea>-->
<!--                        <c-input-error :message="form.errors.description" class="mt-2"/>-->
<!--                    </div>-->

                    <div class="form-group">
                        <c-input-label for="company_activities" :value="__('Company Activities')"/>
                        <Multiselect
                            :createTag="true"
                            :disabled="isDisableInput"
                            :noResultsText="__('Select no result found')"
                            id="company_activities"
                            :placeholder="__('Company Activities')"
                            mode="tags"
                            :searchable="true"
                            :options="companyActivities"
                            v-model="form.activities"/>
                        <c-input-error :message="form.errors.activities" class="mt-2"/>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <c-button
                                @click="submit"
                                v-if="!isDisableInput"
                                class="btn btn-primary font-weight-bold px-4"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ __('Company save') }}
                            </c-button>
<!--                            <c-button-->
<!--                                v-if="isDisableInput"-->
<!--                                @click.prevent="toggleInputDisable"-->
<!--                                class="btn btn-info ml-3 px-4 font-weight-bold"-->
<!--                                :class="{ 'opacity-25': form.processing }"-->
<!--                                :disabled="form.processing">-->
<!--                                {{ __('Edit company data') }}-->
<!--                            </c-button>-->
                            <c-button
                                @click="refreshPage"
                                v-if="!isDisableInput"
                                class="btn btn-danger ml-3 font-weight-bold pull-right">
                                {{ __('Canceled company data Update') }}
                            </c-button>
                        </div>
                    </div>
            </template>
        </c-card>
    </div>
</template>

<script>
import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
import Authenticate from "@/Layouts/Authenticate";
import CInput from "@/CoreUi/components/Input";
import CTextarea from "@/CoreUi/components/Textarea";
import CInputError from "@/CoreUi/components/InputError";
import CValidationErrors from "@/CoreUi/components/ValidationErrors";
import CButton from "@/CoreUi/components/Button";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CCard from "@/CoreUi/components/Card";
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        CSuccessLabel,
        Authenticate,
        CInput,
        CTextarea,
        CInputError,
        CValidationErrors,
        CButton,
        CInputLabel,
        CCard,
        Multiselect
    },
    props: {
        item: {
            type: Object,
            default: null
        },
        options: {
            type: Array,
            default: []
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                id: this.item ? this.item.id : null,
                photo: null,
                title: '',
                description: '',
                identity_id: '',
                activities: []
            }),
            photoPreview: null,
            isDisableInput: false
        }
    },
    created () {
        if (this.item) {
            this.form = {...this.form,...this.item}
            this.form.id = this.item.id
        }
    },
    computed: {
        companyActivities () {
            return this.options ? this.options.company_activities : []
        }
    },
    methods: {
        refreshPage () {
            window.location.reload()
        },
        toggleInputDisable () {
            this.isDisableInput = !this.isDisableInput
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
        submit() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }
            this.form
                .transform(data => ({
                    ... data
                }))
                .post(this.route('company.store'),{
                    onSuccess: () => {
                        this.form.reset()
                    },
                })
        }
    }

}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
