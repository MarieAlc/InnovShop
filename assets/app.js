
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.addEventListener("DOMContentLoaded", () => {
  const burger = document.querySelector(".burger");
  const navCollapse = document.querySelector(".navbar-collapse");

  if (burger && navCollapse) {
    burger.addEventListener("click", () => {
      navCollapse.classList.toggle("open");
    });
  }
});


