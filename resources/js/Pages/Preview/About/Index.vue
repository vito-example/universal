<template>
  <landing class="about-page">
    <template v-slot:main>
      <breadcrumb/>

      <div class="content container container--small margin-top-40">
        <img src="https://dummyimage.com/856x380/b3b3b3/fff.jpg" class="border-radius-10" alt="">

        <h2 class="font-weight-600 margin-top-40">კომპანიის შესახებ</h2>

        <div class="font-size-sm font-weight-300 line-height-default margin-top-24">
          <strong>„აგრარიუმი“ არის სოფლის მეურნეობის მიმართულების სასწავლო ტრენინგ ცენტრი</strong>, რომელიც
          <br>
          ჩამოყალიბდა შ.პ.ს <strong>„ნობლექსი“-ს</strong> ბაზაზე 2021წელს და ახორციელებს პრაქტიკულ ტრენინგებს აგრონომიის მიმართულებით.
          <br>
          <br>
          აგრარიუმის შექმნის იდეაა, სოფლის მეურნეობის მიმართულებით მომუშავე <strong>კომპანიებისა და </strong>
          <strong>ფერმერებისათვის პრაქტიკული ტრენინგების შეთავაზება და არსებული გამოცდილების გაზიარება.</strong>
          <br>
          <br>
          თითოეული ტრენინგის თემატიკა, <strong>შემუშავებულია კომპანიებისა და ფერმერების აქტუალურ პრობლემებზე</strong>
          <strong>დაყრდნობით.</strong>
          <br>
          <br>
          მოწვეული <strong>ტრენერები არიან სფეროს უშუალო წარმომადგენლები,</strong> რომლებსაც აქვთ კონკრეტულ სფეროში
          მოღვაწეობისა და ტრენინგების აქტიურად
          <br>
          ჩატარების მრავალწლიანი გამოცდილება.
        </div>

        <div class="margin-top-40">
          <div class="row">
            <div class="col-lg-6">
              <img src="https://dummyimage.com/416x212/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>

            <div class="col-lg-6">
              <img src="https://dummyimage.com/416x212/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>
          </div>
        </div>

        <h2 class="font-weight-600 margin-top-40">ჩვენი მისია</h2>

        <div class="font-size-sm font-weight-300 line-height-default margin-top-24">
          <strong>„აგრარიუმი“ არის სოფლის მეურნეობის მიმართულების სასწავლო ტრენინგ ცენტრი</strong>, რომელიც
          <br>
          ჩამოყალიბდა შ.პ.ს <strong>„ნობლექსი“-ს</strong> ბაზაზე 2021წელს და ახორციელებს პრაქტიკულ ტრენინგებს აგრონომიის მიმართულებით.
          <br>
          <br>
          აგრარიუმის შექმნის იდეაა, სოფლის მეურნეობის მიმართულებით მომუშავე <strong>კომპანიებისა და </strong>
          <strong>ფერმერებისათვის პრაქტიკული ტრენინგების შეთავაზება და არსებული გამოცდილების გაზიარება.</strong>
          <br>
          <br>
          თითოეული ტრენინგის თემატიკა, <strong>შემუშავებულია კომპანიებისა და ფერმერების აქტუალურ პრობლემებზე</strong>
          <strong>დაყრდნობით.</strong>
          <br>
          <br>
          მოწვეული <strong>ტრენერები არიან სფეროს უშუალო წარმომადგენლები,</strong> რომლებსაც აქვთ კონკრეტულ სფეროში
          მოღვაწეობისა და ტრენინგების აქტიურად
          <br>
          ჩატარების მრავალწლიანი გამოცდილება.
        </div>

        <div class="margin-top-40">
          <div class="row">
            <div class="col-lg-6">
              <img src="https://dummyimage.com/416x212/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>

            <div class="col-lg-6">
              <img src="https://dummyimage.com/416x212/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>
          </div>
        </div>

        <h4 class="font-weight-600 margin-top-48">ფოტო გალერეა</h4>

        <div class="margin-top-32">
          <div class="row">
            <div class="col-lg-3">
              <img src="https://dummyimage.com/196x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>

            <div class="col-lg-3">
              <img src="https://dummyimage.com/196x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>

            <div class="col-lg-3">
              <img src="https://dummyimage.com/196x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>

            <div class="col-lg-3">
              <img src="https://dummyimage.com/196x130/b3b3b3/fff.jpg" class="border-radius-10" alt="">
            </div>
          </div>
        </div>
      </div>
    </template>
  </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb";

export default {
  components: {
    Landing,
    Breadcrumb
  }
}
</script>
