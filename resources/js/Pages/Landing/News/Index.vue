<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :active="__('სიახლეები')" />
            <div class="content container">
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
                        <news-item
                                :item="item"
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
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import SelectObject from "@/Components/Web/Select/SelectObject"
import FilterIcon from "@/Components/Web/Icons/Filter"
import SelectTree from "@/Components/Web/Select/SelectTree"
import NewsItem from "@/Components/News/NewsItem"

export default {
    components: {
        Landing,
        Breadcrumb,
        SelectObject,
        FilterIcon,
        SelectTree,
        NewsItem
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
    },
    data() {
        return {
            filterDrawer: false,
            form: this.$inertia.form({
                directions:  this.selectedDirections ?? [],
            }),
        }
    },
    watch: {
        'form.directions'(value, old) {
            this.submitFilter(value,old)
        },
    },
    methods: {
        getSelectedValue(item) {
            if (item.selected) {
                this.form[`${item.model}`] = item.selected.value;
            }
        },
        submitFilter(value, old,mobile = false) {
            if (value !== old && (!this.filterDrawer || mobile)) {
                this.filterDrawer = false;
                this.form.get(this.route, {
                    onSuccess: () => console.log('success'),
                })
            }
        },
        changeDirections(item){
            if (item.length !== undefined) {
                this.form.directions = item;
            }
        }
    }
}
</script>
