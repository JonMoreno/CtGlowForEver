/**
* Directive (v-scroll)
* Purpose: Create a custome directive to
* faciliate when even window scolls.
*/
Vue.directive('scroll', {
  inserted: function (el, binding) {
    let f = function (evt) {
      if (binding.value(evt, el)) {
        window.removeEventListener('scroll', f)
      }
    }
    window.addEventListener('scroll', f)
  }
});

