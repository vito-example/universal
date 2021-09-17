<template>
    <popup
        v-if="visible"
        :title="__('ჩემი კომპანიები')"
        :subtitle="__('აირჩიეთ სასურველიი კომპანია ჩამონათვალიდან')"
    >
        <form class="form margin-top-25" v-if="companies.length" @submit.prevent="submit">
          <hr>

          <div class="form__group margin-bottom-10" v-for="(item,index) in companies">
            <div class="radio">
              <input type="radio" v-model="company_id" :value="item.id" name="radio" :id="`checkBox${index}`">
              <label :for="`checkBox${index}`" class="font-size-2xs">
                  {{item.label}}
              </label>
            </div>
          </div>
          <hr>

          <div class="flex space-between items-center">
            <div>
              <button
                  type="button"
                  class="button button--link color-black text-decoration-none font-size-xs font-weight-500"
                  @click="onCancel"
              >
                {{__('გაუქმება')}}
              </button>
            </div>

            <button type="submit" :class="{'is-disabled': company_id === ''}" class="button button--primary button--shadow button--border">
              {{__('დადასტურება')}}
            </button>
          </div>
        </form>
        <div class="margin-top-25" v-else>
            <hr>
            <div class="form__group margin-bottom-10">
                <p>{{__('კომპანია არ მოიძებნა')}}</p>
            </div>
            <hr>
        </div>
    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button";

export default {
    components: {
      Button,
        Popup
    },

    data() {
        return {
            visible: false,
            companies: [],
            company_id: ''
        }
    },

    methods: {
      onCancel () {
        this.visible = false;
        this.company_id = '';
      },
        submit() {
            this.$emit('input',this.company_id);
            this.company_id = '';
            this.visible = false;
        }
    },

    mounted() {
        emitter.on('showMyCompaniesPopup', (item) => {
            this.companies = item.companies;
            this.company_id = item.company_id;
            this.visible = true
        })
    }
}
</script>
