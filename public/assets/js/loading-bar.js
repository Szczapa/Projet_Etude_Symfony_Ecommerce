"use strict";

const indicator = document.querySelector(".loading-bar"),
  main = document.querySelector("main"),
  options = {},
  observer = new IntersectionObserver(setIndicator, options);
observer.observe(main);

function setIndicator(entries) {
  let entry = entries[0];
  if (entry.isIntersecting) {
    window.addEventListener("scroll", indicatorAnimation);
  } else {
    window.removeEventListener("scroll", indicatorAnimation);
  }
}

function indicatorAnimation() {
  if (window.scrollY > main.offsetTop) {
    const height =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;

    const prc = (window.scrollY / height).toFixed(2);
    indicator.style.transform = `scaleX(${prc})`;
    console.log(prc, window.scrollY, main.offsetTop, main.scrollHeight);
  } else {
    indicator.style.transform = "scaleX(0)";
  }
}
