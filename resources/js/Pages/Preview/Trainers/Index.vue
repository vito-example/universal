<template>
  <landing>
    <template v-slot:main>
      <breadcrumb/>
      <div class="content container">
        <div class="row margin-top-40">
          <template v-for="item in 8">
            <div class="col-lg-3">
              <div class="person margin-bottom-24">
                <a @click="handleShowTrainer" class="person__image cursor-pointer" title="Name">
                  <img src="https://dummyimage.com/306x400/b3b3b3/fff.jpg" alt="Name">
                  <div class="person__overlay">
                    <div class="person__info">
                      <h5 class="person__title">ირაკლი ქვათაძე</h5>
                      <p class="person__text line-height-default">
                        საქართველოს ტრენერების ასოციაციის უფროსი და მრავალი წლიანი გამოცილების მქონდე ირაკლი ქვათაძე
                        თქვენს სამსახურში
                      </p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </template>
        </div>
      </div>

      <drawer
          title="ირაკლი ქვათაძე"
          sub-title="აგრო-ინჟინერიის დოქტორი, ტრენერი, ლექტორი."
          width="708px"
      >
        <template v-slot:body>
          <p class="font-weight-300 line-height-default">
            მამუკა, თავისი კარიერის განმავლობაში ძალიან აქტიურად იღებდა და იღებს
            მონაწილეობას მექანიზაციის მიმართულებით ტრენინგებში, სამიტებზე,
            კონფერენციებსა და ა.შ მათ შორისაა:
            <br><br>
            „SYSTEMTECHNIK - CLAAS Global Seles GmbH“, (ჰარზევინკელი, გერმანია)
            I- ევრაზიის საერთაშორისო მექანიზაციის სამიტი - სტამბული, თურქეთი
            სასოფლო-სამეურნეო მანქანები - ედე, ჰოლანდია.
            <br><br>
            Land Technic-VDI-გერმანელ ინჟინერთა ასოციაცია ჰანოვერი, გერმანია
            <br><br>
            MASHAV–CINADCO-ტრეინინგ ცენტრი, თელავივი, ისრაელი.
            <br><br>
            მამუკა ასევე, არის - აგროინჟინერიისა და მექანიკის ინჟინერიის პროგრამის
            ხელმძღვანელი აგრარულ უნივერსიტეტში, საინჟინრო-ტექნოლოგიური
            ფაკულტეტის დეკანი და ასოცირებული პროფესორი, მას ძალიან აქტიურად
            უწევს მუშაობა სხვადასხვა პროექტებსა და გრანტებში ხელმძღვანელის და
            მრჩეველის პოზიციებზე.
          </p>
        </template>
      </drawer>
    </template>
  </landing>
</template>
<script>
import emitter from "@/Plugins/bus";
import Landing from "@/Layouts/Landing";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";
import Drawer from "@/Components/Web/Drawer/Drawer";

export default {
  components: {
    Landing,
    Breadcrumb,
    Drawer
  },

  methods: {
    handleShowTrainer () {
      emitter.emit('showDrawer')
    }
  }
}
</script>
