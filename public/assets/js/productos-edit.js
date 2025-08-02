$(document).ready(function() {
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Selecciona',
            allowClear: true
        });
    });
    $('#kit').change(function() {
      if ($(this).is(':checked')) {
        $('select[name="kit_producto"]').prop('disabled', false).prop('required', true);
        $('input[name="kit_cantidad"]').prop('disabled', false).prop('required', true);
        $('input[name="kit_cantidad"]').focus();
        $('.required_input').show();

      } else {
        $('select[name="kit_producto"]').prop('disabled', true).prop('required', false);
        $('input[name="kit_cantidad"]').prop('disabled', true).prop('required', false);
        $('select[name="kit_producto"]').val(null).trigger('change');
        $('input[name="kit_cantidad"]').val(null).trigger('change');
        $('.required_input').hide();
      }
    });
    $('select[name="kit_producto"]').on('change', function(){
      let product   = $(this).val();
      let url       = base_url + "producto-costo/producto/" + product;
      let cantidad  = $('#kit_cantidad').val()
      $.get( url, function( resp ) {
        if(resp.ok && resp.producto.costo > 0 && cantidad > 0){
            $('#costo').val( parseFloat(resp.producto.costo * cantidad).toFixed(2) );
          showMessage('alert-info', 'Costo de Kit calculado automaticamente, favor de validarlo.')
        }
      });
    })
});