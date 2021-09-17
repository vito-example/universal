<template>
    <popup
        v-if="visible"
        :title="__('ჩემი თანამშრომლები')"
        subtitle="აირჩიეთ სასურველიი თანამშრომლები"
    >
        <form class="form margin-top-25" v-if="employeeOptions.length" @submit.prevent="submit">
          <hr>

          <div class="form__group margin-bottom-10" v-for="(item,index) in employeeOptions">
            <div class="checkbox">
              <input type="checkbox" :value="item.id" :id="`checkBox${index}`" v-model="employees">
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

            <button type="submit" :class="{'is-disabled': !employees.length}" class="button button--primary button--shadow button--border">
              {{__('დადასტურება')}}
            </button>
          </div>
        </form>
        <div class="margin-top-25" v-else>
            <hr>
            <div class="form__group margin-bottom-10">
                <p>{{__('თანამშრომელი არ მოიძებნა')}}</p>
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
            employeeOptions: [],
            employees: []
        }
    },

    methods: {
      onCancel () {
          this.employeeOptions = [];
          this.employees = [];
        this.visible = false;
      },
        submit() {
            this.$emit('input',this.employees);
            this.employees = [];
            this.visible = false;
        }
    },

    mounted() {
        emitter.on('showMyColleaguesPopup', (data) => {
            this.employeeOptions = data.employeeOptions;
            this.employees = data.employees;
            this.visible = true
        })
    }
}
</script>
