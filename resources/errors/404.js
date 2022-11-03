document.addEventListener('DOMContentLoaded', function () {
var anchoVentana = screen.width
function AutoRefresh() {
    location.reload(true);
 }
window.onresize = function(){

    anchoVentana = screen.width;
    console.log(anchoVentana)
    AutoRefresh()
   };
   if(anchoVentana > 1366 ){
    let image=document.querySelector('img');
    image.setAttribute('src','/imagenes/error/error404.png');
    let map='';
    map+=`<map name="frasco">
    <area shape="circle" coords="430,540,35" href="/html/dashboard.html" alt="hola">
</map>`;
document.getElementById('click').setAttribute('class','hide');
document.getElementById('mapa').innerHTML=map;
  }else if(anchoVentana > 999 && anchoVentana < 1367){
    document.querySelector('img').setAttribute('src','/imagenes/error/3error404.png')
  }else if(anchoVentana > 602 && anchoVentana< 1000) {
    document.querySelector('img').setAttribute('src','/imagenes/error/error404.gif')
  }else {
    document.querySelector('img').setAttribute('src','/imagenes/error/2error404.png')
  }
})