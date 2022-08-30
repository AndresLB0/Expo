document.addEventListener('DOMContentLoaded', function() {
    //   script para el combobox
    var instances = M.FormSelect.init(document.querySelectorAll('select'));
    var instances = M.Tabs.init(document.querySelector('.tabs', {
      swipeable: true,
    }));
    var instances = M.Sidenav.init(document.querySelectorAll('.sidenav'));
  });

  