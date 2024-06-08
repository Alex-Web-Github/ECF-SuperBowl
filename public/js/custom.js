// Assombrir le Header au Scroll
document.addEventListener('DOMContentLoaded', function () {
  window.onscroll = function () {
    var header = document.getElementById('customHeader');
    if (window.scrollY > 50) {
      header.classList.add('scroll-effect');
    } else {
      header.classList.remove('scroll-effect');
    }
  };
});