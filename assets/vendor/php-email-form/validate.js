/**

/*(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  forms.forEach( function(e) {
    e.addEventListener('submit', function(event) {
      event.preventDefault();

      let thisForm = this;

      let action = thisForm.getAttribute('action');
      let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');
      
      if( ! action ) {
        displayError(thisForm, 'The form action property is not set!');
        return;
      }
      thisForm.querySelector('.loading').classList.add('d-block');
      thisForm.querySelector('.error-message').classList.remove('d-block');
      thisForm.querySelector('.sent-message').classList.remove('d-block');

      let formData = new FormData( thisForm );

      if ( recaptcha ) {
        if(typeof grecaptcha !== "undefined" ) {
          grecaptcha.ready(function() {
            try {
              grecaptcha.execute(recaptcha, {action: 'php_email_form_submit'})
              .then(token => {
                formData.set('recaptcha-response', token);
                php_email_form_submit(thisForm, action, formData);
              })
            } catch(error) {
              displayError(thisForm, error);
            }
          });
        } else {
          displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
        }
      } else {
        php_email_form_submit(thisForm, action, formData);
      }
    });
  });

  function php_email_form_submit(thisForm, action, formData) {
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(response => {
      if( response.ok ) {
        return response.text();
      } else {
        throw new Error(`${response.status} ${response.statusText} ${response.url}`); 
      }
    })
    .then(data => {
      thisForm.querySelector('.loading').classList.remove('d-block');
      if (data.trim() == 'OK') {
        thisForm.querySelector('.sent-message').classList.add('d-block');
        thisForm.reset(); 
      } else {
        throw new Error(data ? data : 'Form submission failed and no error message returned from: ' + action); 
      }
    })
    .catch((error) => {
      displayError(thisForm, error);
    });
  }

  function displayError(thisForm, error) {
    thisForm.querySelector('.loading').classList.remove('d-block');
    thisForm.querySelector('.error-message').innerHTML = error;
    thisForm.querySelector('.error-message').classList.add('d-block');
  }

})();*/

(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  forms.forEach(function (e) {
    e.addEventListener('submit', function (event) {
      event.preventDefault();

      let thisForm = this;

      // Validación de nombres y apellidos (solo letras)
      let nombresInput = thisForm.querySelector('input[name="nombres"]');
      let apellidosInput = thisForm.querySelector('input[name="apellidos"]');
      if (!validarSoloLetras(nombresInput.value) || !validarSoloLetras(apellidosInput.value)) {
        mostrarError(thisForm, 'Por favor, ingrese solo letras en los campos de nombres y apellidos.');
        return;
      }

      // Validación de teléfono (exactamente 10 números)
      let telefonoInput = thisForm.querySelector('input[name="telefono"]');
      if (!validarTelefono(telefonoInput.value)) {
        mostrarError(thisForm, 'Por favor, ingrese un número de teléfono válido (10 dígitos).');
        return;
      }

      // Resto del código...

      let formData = new FormData(thisForm);

      fetch(thisForm.action, {
          method: 'POST',
          body: formData
      })
      .then(response => response.text())
      .then(data => {
          console.log('Respuesta del servidor:', data); // Agregamos esta línea para depurar
          if (data.trim() === "Datos guardados correctamente") {
              mostrarExito(thisForm);
          } else {
              mostrarError(thisForm, 'Hubo un problema al enviar tu cotización. Por favor, inténtalo de nuevo.');
          }
      })
      .catch(error => {
          console.error('Error en la solicitud:', error);
          mostrarError(thisForm, 'Hubo un problema al enviar tu cotización. Por favor, inténtalo de nuevo.');
      });
    });
  });

  function validarSoloLetras(valor) {
    // Expresión regular para validar solo letras (sin espacios)
    return /^[A-Za-z]+$/.test(valor);
  }

  function validarTelefono(valor) {
    // Expresión regular para validar exactamente 10 números
    return /^\d{10}$/.test(valor);
  }

  function mostrarExito(formulario) {
    Swal.fire({
        title: 'Éxito',
        text: 'Tu cotización ha sido enviada correctamente.',
        icon: 'success',
        confirmButtonText: 'Ok'
    }).then(() => {
        // Puedes redirigir a otra página después del éxito si es necesario
        // window.location.href = 'tu_pagina_exitosa.php';
        formulario.reset(); // Limpia el formulario después del éxito
    });
  }

  function mostrarError(formulario, mensaje) {
    Swal.fire({
        title: 'Error',
        text: mensaje,
        icon: 'error',
        confirmButtonText: 'Ok'
    });
  }

})();
