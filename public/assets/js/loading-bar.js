"use strict";

// constante indicators -> séléctionne l'élément div de class loading-bar
const indicator = document.querySelector(".loading-bar"),
  // constante main -> séléctionne l'élément main
  main = document.querySelector("main"),
  // constante option -> objet vide
  options = {},
  // constante obeserver -> nouvel observer d'intersection avec une fonction callback setIndicator et l'objet option en paramètre
  observer = new IntersectionObserver(setIndicator, options);

// Observer doit observer main
observer.observe(main);

//Fonction call back de l'observer
function setIndicator(entries) {
  // entry = valeur d'entrée de l'observer
  let entry = entries[0];
  // Si entry est a une intersection
  if (entry.isIntersecting) {
    // On modifie la barre de chargement
    window.addEventListener("scroll", indicatorAnimation);
  } else {
    // Sinon on remove scroll
    window.removeEventListener("scroll", indicatorAnimation);
  }
}

// function animation de scroll
function indicatorAnimation() {
  // Si le  scroll sur la fenêtre sur l'axe Y est inférieur à l'offset top du main
  if (window.scrollY > main.offsetTop) {
    // Constante height = hauteur total du scrolling de la page - la hauteur total de l'affichage client
    const height =
      document.documentElement.scrollHeight -
      document.documentElement.clientHeight;

    // constante prc = au scroll de la fenetre en Y / la hauteur à 0.2 chiffre après la virgule
    const prc = (window.scrollY / height).toFixed(2);
    // On transforme sur l'axe X le scale de la div indicator en fonction de la valeur de prc
    indicator.style.transform = `scaleX(${prc})`;
    // console.log(prc, window.scrollY, main.offsetTop, main.scrollHeight);
  } else {
    // Sinon on la scale à 0
    indicator.style.transform = "scaleX(0)";
  }
}
