const slider = document.querySelector("#slider");
let sliderSections = document.querySelectorAll(".slider__section");
let sliderSectionLast = sliderSections[sliderSections.length - 1];

const btnLeft = document.querySelector("#btn-left");
const btnRight = document.querySelector("#btn-right");

slider.insertAdjacentElement('afterbegin', sliderSectionLast);

function updateSliderSections() {
    sliderSections = document.querySelectorAll(".slider__section");
}

function updateActiveClass() {
    sliderSections.forEach(section => {
        section.classList.remove('active');
    });
    sliderSections[1].classList.add('active');
}

function moveSlider(newMargin, callback) {
    slider.style.marginLeft = newMargin;
    slider.style.transition = "all 0.5s";
    setTimeout(function () {
        slider.style.transition = "none";
        callback();
        updateSliderSections(); // Actualiza las secciones del carrusel después del movimiento
        updateActiveClass(); // Actualiza la clase activa después del movimiento
    }, 500);
}

function next() {
    let sliderSectionFirst = sliderSections[0];
    moveSlider("-200%", function() {
        slider.insertAdjacentElement('beforeend', sliderSectionFirst);
        slider.style.marginLeft = "-100%";
    });
}

function prev() {
    let sliderSectionLast = sliderSections[sliderSections.length - 1];
    moveSlider("0", function() {
        slider.insertAdjacentElement('afterbegin', sliderSectionLast);
        slider.style.marginLeft = "-100%";
    });
}

btnRight.addEventListener('click', function () {
    next();
});

btnLeft.addEventListener('click', function () {
    prev();
});

setInterval(function () {
    next();
}, 5000);

// Inicialización en la carga de la página
document.addEventListener('DOMContentLoaded', function () {
    updateSliderSections();
    updateActiveClass();
});


