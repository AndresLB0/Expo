
  document.addEventListener('DOMContentLoaded', function() {
    //   script para el combobox
    var instances = M.FormSelect.init(document.querySelectorAll('select'));
    // script para elejir fecha
    var instances = M.Datepicker.init(document.querySelectorAll('.datepicker'),{
    format:'dd/mm/yyyy',
    defaultDate:new Date(),
    setDefaultDate: true,
    i18n: {
    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Juni', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
      weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
      weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
      monthsShort: ['ene', 'Feb', 'Mar', 'Abr', 'Mayo', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    }
  });
  // script para pestañas
  var instances = M.Tabs.init(document.querySelector('.tabs',{
    swipeable:true,
  }));
  });
  
  //feacha y hora
  function reloj(){
  fecha = new Date();
  anno = fecha.getFullYear();
  mes = fecha.getMonth()+1;
  dia=fecha.getDate();
  diasem = fecha.getDay();
  document.getElementById("hoy").innerHTML = dia+"/"+mes+'/'+anno;
  //hora actual
 tiempo = new Date();
hora = tiempo.getHours();
if(hora<10)hora="0"+hora
 min = tiempo.getMinutes();
if(min<10)min="0"+min;
horacompleta=hora+":"+min;
  document.getElementById('hora').innerHTML=horacompleta ;
  setTimeout('reloj()',1000)
  }