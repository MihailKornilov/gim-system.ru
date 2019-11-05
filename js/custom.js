'use strict';

document.addEventListener('DOMContentLoaded', function(){

//  documentation menu
  if(document.getElementsByClassName('doc-sidebar__arrow').length > 0){
    document.querySelectorAll('.doc-sidebar__arrow').forEach(function (arrow) {
      arrow.addEventListener('click', function (e) {
        e.preventDefault();
        this.closest('.doc-sidebar__item').classList.toggle('doc-sidebar__item_opened');
      })
    });
      document.getElementsByClassName('doc-info__mobile-menu')[0].addEventListener('click', function () {
        this.classList.toggle('doc-info__mobile-menu_opened');
        document.getElementsByClassName('doc-sidebar')[0].classList.toggle('doc-sidebar_opened');
      })
  }

//  mobile menu
  if(document.getElementsByClassName('navigation-mobile').length > 0){
    document.getElementsByClassName('navigation-mobile')[0].addEventListener('click', function () {
      this.parentElement.querySelector('.menu').classList.toggle('menu_open');
    });
  }

//  faqs
  document.querySelectorAll('.faqs-item__btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      this.closest('.faqs-item').classList.toggle('faqs-item_opened');
      this.innerText === '+' ? this.innerText = '-' : this.innerText = '+';
    })
  });

});