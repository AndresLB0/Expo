
  document.addEventListener('DOMContentLoaded', function() {
  var instances = M.Tabs.init(document.querySelector('.tabs',{
    swipeable:true,
  }));
  var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
  });
  //feacha y hora
  function reloj(){
  fecha = new Date();
  anno = fecha.getFullYear();
  mes = fecha.getMonth()+1;
  dia=fecha.getDate();
  diasem = fecha.getDay();
  document.getElementsByClassName("hoy").innerHTML = dia+"/"+mes+'/'+anno;
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