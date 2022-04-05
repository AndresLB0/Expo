
  document.addEventListener('DOMContentLoaded', function() {
    //   script para el combobox
    var instances = M.FormSelect.init(document.querySelectorAll('select'));
    // script para elejir fecha
    var instances = M.Datepicker.init(document.querySelectorAll('.datepicker'));
  });