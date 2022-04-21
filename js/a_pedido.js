
  document.addEventListener('DOMContentLoaded', function() {
    //   script para el combobox
    var instances = M.FormSelect.init(document.querySelectorAll('select'));
  });

        // Add input dropdown
        this.input = document.createElement('input');
        $(this.input).addClass('select-dropdown dropdown-trigger');
        this.input.setAttribute('type', 'search');
        this.input.setAttribute('readonly', 'false');
        this.input.setAttribute('data-target', this.dropdownOptions.id);
        if (this.el.disabled) {
          $(this.input).prop('disabled', 'true');
        }

        this.$el.before(this.input);
        this._setValueToInput();