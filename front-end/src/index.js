
/* Configuración de la API */
const BASE_URL = 'http://127.0.0.1:8000/v1/';

/* Solo permitir números en los inputs */
document.addEventListener('DOMContentLoaded', function () {

  // Función para validar que solo se ingresen números
  function validateNumbersInput(inputElement) {
    inputElement.addEventListener('input', function (event) {
      const value = event.target.value;
      const regex = /^[0-9]*$/; // Expresión regular para aceptar solo números

      if (!regex.test(value)) {
        event.target.value = value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
      }
    });
  }

  // Aplicar la validación a los campos de entrada
  validateNumbersInput(cellphoneInput);
  validateNumbersInput(dniInput);
});

/* Carrucel  */
const btnLeft = document.querySelector(".btn-left"),
  btnRight = document.querySelector(".btn-right"),
  slider = document.querySelector("#slider"),
  sliderSection = document.querySelectorAll(".slider-section"),
  cellphoneInput = document.getElementById('cellphone'),
  dniInput = document.getElementById('dni');

let intervalID;

btnLeft.addEventListener("click", e => moveToLeft())
btnRight.addEventListener("click", e => moveToRight())

intervalID = setInterval(() => {
  moveToRight();
}, 6000);

// Función para detener el intervalo del carrusel
function stopCarousel() {
  clearInterval(intervalID);
}

// Función para reanudar el intervalo del carrusel
function startCarousel() {
  intervalID = setInterval(() => {
    moveToRight();
  }, 7000);
}

// Agregar event listeners para detectar cuando se escribe en los campos de entrada
cellphoneInput.addEventListener('focus', stopCarousel);
cellphoneInput.addEventListener('blur', startCarousel);
dniInput.addEventListener('focus', stopCarousel);
dniInput.addEventListener('blur', startCarousel);

let operacion = 0,
  counter = 0,
  widthImg = 100 / sliderSection.length;

function moveToRight() {
  if (counter >= sliderSection.length - 1) {
    counter = 0;
    operacion = 0;
    slider.style.transform = `translate(-${operacion}%)`;
    slider.style.transition = "none";
    return;
  }
  counter++;
  operacion = operacion + widthImg;
  slider.style.transform = `translate(-${operacion}%)`;
  slider.style.transition = "all ease .6s"

}

function moveToLeft() {
  counter--;
  if (counter < 0) {
    counter = sliderSection.length - 1;
    operacion = widthImg * (sliderSection.length - 1)
    slider.style.transform = `translate(-${operacion}%)`;
    slider.style.transition = "none";
    return;
  }
  operacion = operacion - widthImg;
  slider.style.transform = `translate(-${operacion}%)`;
  slider.style.transition = "all ease .6s"
}

/* Parte del formulario */
const form = document.getElementById('customerForm');
const responseMessage = document.getElementById('responseMessage');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const cellphone = cellphoneInput.value;
  const dni = dniInput.value;

  fetch(`${BASE_URL}customers/dataCustomer`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ cellphone, dni })
  })
    .then(response => response.json())
    .then(data => {
      if (data.code === 200) {
        showMessage(data.data.message, 'success');
      } else {
        showMessage('¡Ocurrió un problema! Lo estamos solucionando', 'error');
      }
      clearInputs();
    })
    .catch(error => {
      showMessage('¡Ocurrió un problema! Lo estamos solucionando', 'error');
      console.error('Error:', error);
    });
});

function showMessage(message) {
  alert(message);
  // Ocultar el botón "callme"
  const callmeButton = document.getElementById('callme');
  if (callmeButton) {
    callmeButton.style.display = 'none';
  }
}

function clearInputs() {
  cellphoneInput.value = '';
  dniInput.value = '';
}