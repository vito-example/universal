<template>
    <landing>
        <template v-slot:main>
            <breadcrumb />
            <div class="trainings container">
              <div class="row margin-y-40">
                <div class="col-lg-3">
                  <CustomSelect
                      :options="['ტრენინგის მიმართულება', 'მარცხნივ', 'მარჯვნივ', 'ორივე']"
                      :default="'ტრენინგის მიმართულება'"
                      class="select"
                  />
                </div>

                <div class="col-lg-3">
                  <CustomSelect
                      :options="['ტრენინგის ტიპი', 'იმნაირი', 'ამნაირი', 'ორივე']"
                      :default="'ტრენინგის ტიპი'"
                      class="select"
                  />
                </div>

                <div class="col-lg-3">
                  <CustomSelect
                      :options="['ჩატარრების ადგილი', 'წაღვერი', 'წაღვერი', 'ორივე']"
                      :default="'ჩატარრების ადგილი'"
                      class="select"
                  />
                </div>
              </div>
              <div class="row">
                <template v-for="item in 9" :key="item">
                  <div class="col-lg-4">
                    <div class="card margin-bottom-44">
                      <div class="card__body">
                        <inertia-link :href="`/preview/trainings/show`" class="card__image" title="სათაური">
                          <img src="https://dummyimage.com/352x180/b3b3b3/fff.jpg" alt="სათაური">
                        </inertia-link>

                        <h4 class="card__title">როგორ ვებრძოლოთ დაავადებებს მცენარეებში</h4>
                        <p class="card__text font-weight-400 line-height-default">
                          ტრენინგის ფარგლებში გაეცნობით იმ
                          თანამედროვე ხერხებსა და ტენდენციებს
                          რაც დაგეხმარებათ უკედ ებრძოლოთ....
                        </p>

                        <div class="flex margin-top-29">
                          <div class="label label--light-outline flex items-center">
                            <div class="label__icon line-height-0 padding-right-8">
                              <calendar-icon width="16" height="16" />
                            </div>

                            20 აგვ 2021
                          </div>
                          <div class="label label--light-outline flex items-center margin-left-12">
                            <div class="label__icon line-height-0 padding-right-8">
                              <cash-icon width="16" height="12"/>
                            </div>

                            ფასი: 1000 ₾
                          </div>
                        </div>

                        <a href="#" class="color-black text-decoration-none block margin-top-29">რეგისტრაცია</a>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import CashIcon from "@/Components/Web/Icons/Cash";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import CustomSelect from "@/Components/Web/Select/Select";

export default {
    components: {
        Landing,
        Breadcrumb,
        CalendarIcon,
        CashIcon,
        CustomSelect
    }
}
</script>
