

const ENDPOINT_CARGO=SERVER +'dashboard/cargo.php?action=readAll'
fillSelect(ENDPOINT_CARGO, 'cargo', null);
document.getElementById('save-form').addEventListener('submit', function (event) {
  // Se evita recargar la página web después de enviar el formulario.
  event.preventDefault();
  var hcaptchaVal = document.getElementById('h-captcha-response').value;
   if (hcaptchaVal === "") {
      alert("Please complete the hCaptcha");
   }
  // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario será para crear.
  (document.getElementById('id').value);
  // Se llama a la función para guardar el registro. Se encuentra en el archivo components.js
  saveRow(API_PERSO,'create', 'save-form','JavaScript:history.back()');
});
