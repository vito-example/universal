<template>
    <div>
        <c-card class="card-accent-primary">
            <template v-slot:header>
                <span class="font-weight-bold">{{ item.title }}</span>
            </template>
            <template v-slot:body>
                <div class="row">
                    <div class="form-group col-md-12">
                        <inertia-link class="no-underline hover:underline text-black float-left" :href="item.edit_url" v-if="item.image_url">
                            <img alt="Placeholder" class="img-thumbnail mr-3" :src="item.image_url" style="width: 6rem;">
                        </inertia-link>
                    </div>
                    <div class="form-group col-12">
                        <c-input-label for="name" :value="__('Company title')"/>
                        <c-input :disabled="true"  id="name" type="text" v-model="item.title" autofocus>
                        </c-input>
                    </div>
                    <div class="form-group col-12">
                        <c-input-label for="identity_id" :value="__('Company identity id')"/>
                        <c-input :disabled="true"  id="identity_id" type="text" v-model="item.identity_id" autofocus>
                        </c-input>
                    </div>
                    <div class="form-group col-md-12">
                        <c-input-label for="company_activities" :value="__('Company Activities')"/>
                        <Multiselect
                            :disabled="true"
                            :noResultsText="__('Select no result found')"
                            id="company_activities"
                            :placeholder="__('Company Activities')"
                            v-model="item.activities_id"
                            mode="tags"
                            :searchable="true"
                            :options="options.company_activities"/>
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <inertia-link :href="item.edit_url">
                    <c-button
                        class="btn btn-info ml-3 px-4 font-weight-bold">
                        {{ __('Edit company data') }}
                    </c-button>
                </inertia-link>
            </template>
        </c-card>
    </div>
</template>

<script>
import CCard from "@/CoreUi/components/Card";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CInput from "@/CoreUi/components/Input";
import Multiselect from "@vueform/multiselect";

export default {
    components: {
        CCard,
        CInputLabel,
        CInput,
        Multiselect
    },
    props: {
        item: {
            type: Object
        },
        options: {
            type: Object
        }
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
