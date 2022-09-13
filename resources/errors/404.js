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
    document.querySelector('img').setAttribute('src','/expo/imagenes/error/error404.png')
   
  }else if(anchoVentana > 999 && anchoVentana < 1367){
    document.querySelector('img').setAttribute('src','/expo/imagenes/error/error404.gif')
  }else if(anchoVentana > 602 && anchoVentana< 1000) {
    document.querySelector('img').setAttribute('src','/expo/imagenes/error/3error404.png')
  }else {
    document.querySelector('img').setAttribute('src','/expo/imagenes/error/2error404.png')
  }
})