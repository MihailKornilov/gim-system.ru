'use strict';

document.addEventListener('DOMContentLoaded', function(){

//  mobile menu
  document.getElementsByClassName('navigation-mobile')[0].addEventListener('click', function () {
    this.parentElement.querySelector('.menu').classList.toggle('menu_open');
  });
//  faqs
  document.querySelectorAll('.faqs-item__btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      this.closest('.faqs-item').classList.toggle('faqs-item_opened');
      this.innerText === '+' ? this.innerText = '-' : this.innerText = '+';
    })
  });



});