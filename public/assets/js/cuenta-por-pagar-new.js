$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Selecciona',
        allowClear: true
    });

    $('#crearCategoria').on('click', function(){
        $('#modalFacturaCategoria').modal('show');
        $('#modalFacturaCategoria').modal('show');
    });
    
    $(document).on('click', '.editarCategoriaBtn', function(){
        let id = $(this).attr('id_categoria')
        let nombre_categoria = $(this).attr('nombre_categoria')
        $('#crearCategoriaFormContainer').hide();
        $('#editarCategoriaFormContainer').show();
        $('#factura_categoria_edit_nombre').val(nombre_categoria);
        $('#factura_categoria_edit_id').val(id); 
    });

    $(document).on('click', '#editarCategoriaFormCancel', function(){
        $('#crearCategoriaFormContainer').show();
        $('#editarCategoriaFormContainer').hide();
        $('#factura_categoria_nombre').val('');
    });

    $(document).on('click', '#editarCategoriaFormAccept', function(){
        var id          = $('#factura_categoria_edit_id').val()
        var nombre      = $('#factura_categoria_edit_nombre').val()
        var $csrf       = $('input[type="hidden"][name^="csrf"]');
        var csrf_name   = $csrf.attr('name');
        var csrf_value  = $csrf.val();
        
        if(nombre.trim().length < 1){
            showMessage('alert-danger', 'Nombre no puede ir vacio')
            return;
        }
        
        $.post(base_url + '/settings/contabilidad/facura-categoria-edit', { [csrf_name]: csrf_value, nombre, id }, function(resp){
            if (resp.csrf_name && resp.csrf_token) {
                actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
            }
            if(resp.ok){
                showMessage('alert-success', 'Elemento actualizado')
                $('#categoria_option_' + id).html(resp.nombre);
                $('#categoria_nombre_' + id).html(resp.nombre);
                $('#categoria_nombre_btn_' + id).attr('nombre_categoria', resp.nombre);
                $('#crearCategoriaFormContainer').show();
                $('#editarCategoriaFormContainer').hide();
                $('#factura_categoria_nombre').val('');
            }else{
                showMessage('alert-danger', resp.message)
            }
        })
    });

    $('#crearCategoriaForm').on('click', function(){
        var nombre      = $('#factura_categoria_nombre').val()
        var $csrf       = $('input[type="hidden"][name^="csrf"]');
        var csrf_name   = $csrf.attr('name');
        var csrf_value  = $csrf.val();

        if(nombre.trim().length < 1){
            showMessage('alert-danger', 'Nombre no puede ir vacio')
            return;
        }
        
        $.post(base_url + '/settings/contabilidad/facura-categoria', { [csrf_name]: csrf_value, nombre }, function(resp){
            if (resp.csrf_name && resp.csrf_token) {
                actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
            }
            if(resp.ok){
                showMessage('alert-success', 'Elemento creado')
                const nuevaOption = `
                    <option id="categoria_option_${resp.id}" value="${resp.id}">${resp.nombre}</option>
                `;
                const nuevaFila = `
                  <tr>
                    <td class="px-1">
                      <div class="d-flex justify-content-between align-items-center">
                        <span id="categoria_nombre_${resp.id}">${resp.nombre}</span>
                        <button id="categoria_nombre_btn_${resp.id}" type="button" class="btn btn__simple border editarCategoriaBtn" id_categoria="${resp.id}" nombre_categoria="${resp.nombre}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="18" height="18">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                `;
                $('#facturaCategoriaList').prepend(nuevaFila);
                $('#factura_categoria').append(nuevaOption);
                $('#factura_categoria_nombre').val('');
            }else{
                showMessage('alert-danger', resp.message)
            }
        })
    });

    $('#credito_dias').on('change', function(){
        var dias = parseInt($(this).val(), 10) || 0;
        var fecha_emision = $('#fecha_emision').val();

        if(fecha_emision !== ''){
            let fecha = new Date(fecha_emision);
            fecha.setDate(fecha.getDate() + dias);
            // Formatear a YYYY-MM-DD
            let yyyy = fecha.getFullYear();
            let mm = String(fecha.getMonth() + 1).padStart(2, '0');
            let dd = String(fecha.getDate()).padStart(2, '0');
            let fecha_pago = `${yyyy}-${mm}-${dd}`;
            $('#fecha_pago').val(fecha_pago);
        }
    });
});