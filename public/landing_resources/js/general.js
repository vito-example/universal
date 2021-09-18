const pageNumber = document.querySelectorAll(".page_number");
const pViewImg = document.querySelectorAll(".project_view_image");
const popupView = document.getElementById("project_popup_view");
const closePopup = document.getElementById("close_popup");
const menuBtn = document.getElementById("menu_btn");
const nabvar = document.querySelector(".navbar");

// position aware button
$(function () {
  $(".service_box")
    .on("mouseenter", function (e) {
      var parentOffset = $(this).offset(),
        relX = e.pageX - parentOffset.left,
        relY = e.pageY - parentOffset.top;
      $(this).find("span").css({ top: relY, left: relX });
    })
    .on("mouseout", function (e) {
      var parentOffset = $(this).offset(),
        relX = e.pageX - parentOffset.left,
        relY = e.pageY - parentOffset.top;
      $(this).find("span").css({ top: relY, left: relX });
    });
});

// paginations
pageNumber.forEach((el, i) => {
  el.addEventListener("click", () => {
    pageNumber.forEach((el) => {
      el.classList.remove("active");
    });
    pageNumber[i].classList.add("active");
  });
});

// project popup
pViewImg.forEach((el) => {
  el.addEventListener("click", () => {
    popupView.style.top = "0";
  });
});

if (closePopup) {
  closePopup.addEventListener("click", () => {
    popupView.style.top = "-101%";
  });
}

// mobile menu
if (menuBtn) {
    menuBtn.addEventListener("click", () => {
        menuBtn.classList.toggle("clicked");
        nabvar.classList.toggle("open");
    });
}
