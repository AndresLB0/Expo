
  document.addEventListener('DOMContentLoaded', function() {
    //   script para el combobox
    var instances = M.FormSelect.init(document.querySelectorAll('select'));
    var instances = M.Tabs.init(document.querySelector('.tabs', {
      swipeable: true,
    }));
  });

  document.getElementById('menu').innerHTML ='<ul id="tabs-swipe-demo" class="tabs"><li class="tab col s3"><a href="#pestania1">informacion del pedido</a></li><li class="tab col s3"><a href="#pestania2">detallar pedido</a></li></ul>';