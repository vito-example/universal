<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :active="__('ტრენინგები')" />

            <div class="trainings container">
                <div class="page-filter">
                  <div class="row margin-y-40">
                    <div class="col-3 col-lg-3">
                      <SelectTree
                          :options="directions"
                          :defaultValues="form.directions"
                          :default="__('აირჩიეთ მიმართულება')"
                          class="select"
                          v-if="!filterDrawer"
                          @input="changeDirections"
                      />
                    </div>
                    <div class="col-3 col-lg-3">
                        <SelectObject
                            :options="types"
                            :default="form.type ? types.find(element => element.value == form.type) : ''"
                            class="select"
                            :model="'type'"
                            @input="getSelectedValue"
                        />
                    </div>

                    <div class="col-3 col-lg-3" v-if="trainingType !== 'online'">
                        <SelectObject
                            :options="places"
                            :default="form.place ? places.find(element => element.value == form.place) : ''"
                            class="select"
                            :model="'place'"
                            @input="getSelectedValue"
                        />
                    </div>
                  </div>
                </div>

                <button
                    type="button"
                    class="filter-button button button--link color-black font-size-16 text-decoration-none flex items-center margin-y-40"
                    @click="filterDrawer = !filterDrawer"
                >
                  <FilterIcon />
                  <span class="padding-left-10">{{ __('ფილტრი') }}</span>
                </button>

                <div v-if="filterDrawer" class="mobile-filter">
                  <div class="mobile-filter__inner">

                    <div>
                        <SelectTree
                            :options="directions"
                            :defaultValues="form.directions"
                            :default="__('აირჩიეთ მიმართულება')"
                            class="select"
                            @input="changeDirections"
                        />
                    </div>

                    <div class="margin-top-16">
                        <SelectObject
                            :options="types"
                            :default="form.type ? types.find(element => element.value == form.type) : ''"
                            class="select"
                            :model="'type'"
                            @input="getSelectedValue"
                        />
                    </div>

                    <div class="margin-top-16" v-if="trainingType !== 'online'">
                        <SelectObject
                            :options="places"
                            :default="form.place ? places.find(element => element.value == form.place) : ''"
                            class="select"
                            :model="'place'"
                            @input="getSelectedValue"
                        />
                    </div>

                    <hr class="margin-y-30">

                    <button type="button" @click="submitFilter(1,-1,true)" class="button button--primary button--shadow button--border width-full">{{__('დადასტურება')}}</button>
                  </div>
                </div>

                <div class="row">
                    <div
                            v-for="item in items.data"
                            :key="item.id"
                            class="col-4 col-lg-4 col-md-4 col-sm-12"
                    >
                        <training-item
                                :training="item"
                                :type="trainingType"
                                class="margin-bottom-sm-50"
                        />
                    </div>
                </div>
            </div>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing"
import CalendarIcon from "@/Components/Web/Icons/Calendar"
import CashIcon from "@/Components/Web/Icons/Cash"
import FilterIcon from "@/Components/Web/Icons/Filter"
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import CustomSelect from "@/Components/Web/Select/Select"
import SelectObject from "@/Components/Web/Select/SelectObject"
import SelectTree from "@/Components/Web/Select/SelectTree"
import Button from "../../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button"
import VideoIcon from "@/Components/Web/Icons/Video"
import TrainingItem from "@/Components/Training/TrainingItem"

export default {
    components: {
      Button,
        Landing,
        Breadcrumb,
        CalendarIcon,
        CashIcon,
        FilterIcon,
        CustomSelect,
        SelectObject,
        SelectTree,
        VideoIcon,
        TrainingItem
    },
    props: {
        items: {
            type: Array
        },
        route: {
          type: String
        },
        directions: {
            type: Array
        },
        selectedDirections: {
            type: String
        },
        places: {
            type: Array
        },
        place: {
            type: String
        },
        types: {
            type: Array,
        },
        type: {
            type: String
        },
        trainingType: {
            type: String
        }
    },
    data() {
        return {
            filterDrawer: false,
            form: this.$inertia.form({
                directions:  this.selectedDirections ?? [],
                type:  this.type,
                place: this.place
            }),
        }
    },
    watch: {
        'form.directions'(value, old) {
            this.submitFilter(value,old)
        },
        'form.place'(value, old) {
            this.submitFilter(value,old)
        },
        'form.type'(value, old) {
            this.submitFilter(value,old)
        }
    },
    methods: {
        getSelectedValue(item) {
            if (item.selected) {
                this.form[`${item.model}`] = item.selected.value;
            }
        },
        submitFilter(value, old,mobile = false) {
            if (value != old && (!this.filterDrawer || mobile)) {
                this.filterDrawer = false;
                this.form.get(this.route, {
                    onSuccess: () => console.log('success'),
                })
            }
        },
        changeDirections(item){
            console.log(item)
           if (item.length !== undefined) {
               this.form.directions = item;
           }
        }
    }

}
</script>
