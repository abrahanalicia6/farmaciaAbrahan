$(document).ready(function(){
    var edit=false;
    var funcion;
    buscar_prov();
    $('#form-crear').submit(e=>{
        let id =$('#id_edit_prov').val();
        let nombre =$('#nombre').val();
        let telefono =$('#telefono').val();
        let correo =$('#correo').val();
        let direccion =$('#direccion').val();
        if(edit==true){
            funcion="editar";
        }
        else{
            funcion="crear";
        }
        $.post('../controlador/proveedorController.php',{id,nombre,telefono,correo,direccion,funcion},(response)=>{
            if(response=='add'){
                $('#add-prov').hide('slow');
                $('#add-prov').show(1000);
                $('#add-prov').hide(2000);
                $('#form-crear').trigger('reset');
                
            }
            if(response=='noadd'||response=='noedit'){
                $('#noadd-prov').hide('slow');
                $('#noadd-prov').show(1000);
                $('#noadd-prov').hide(2000);
                $('#form-crear').trigger('reset');
            }
            if(response=='edit'){
                $('#edit-prove').hide('slow');
                $('#edit-prove').show(1000);
                $('#edit-prove').hide(2000);
                $('#form-crear').trigger('reset');
                buscar_prov();
            }
            edit=false;
        });
        e.preventDefault();
    });
    function buscar_prov(consulta){
        funcion="buscar";
        $.post('../controlador/proveedorController.php',{consulta,funcion},(response)=>{
            const proveedores = JSON.parse(response);
            let template='';
            proveedores.forEach(proveedor => {
                template+=`
                <div provId="${proveedor.id}" provNombre="${proveedor.nombre}" provTelefono="${proveedor.telefono}"provCorreo="${proveedor.correo}"provDireccion="${proveedor.direccion}"provAvatar="${proveedor.avatar}"class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                <h1 class="badge badge-secondary">Proveedor</h1>
                </div>
                <div class="card-body pt-0">
                <div class="row">
                    <div class="col-7">
                    <h2 class="lead"><b>${proveedor.nombre}</b></h2>
                    
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Direccion: ${proveedor.direccion}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Teléfono: ${proveedor.telefono}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Correo: ${proveedor.correo}</li>
                    </ul>
                    </div>
                    <div class="col-5 text-center">
                    <img src="${proveedor.avatar}" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                    <button class="avatar btn btn-sm btn-info" title="Editar logo" type="button" data-toggle="modal" data-target="#cambiologo">
                    <i class="fas fa-image"></i>
                    </button>
                    <button class="editar btn btn-sm btn-success" title="Editar proveedor"type="button" data-toggle="modal" data-target="#crearproveedor">
                    <i class="fas fa-pencil"></i>
                    </button>
                    <button class="borrar btn btn-sm btn-danger" title="Eliminar proveedor">
                    <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                </div>
            </div>
            </div>
                `;
            });
            $('#proveedores').html(template);
        });
    }
    $(document).on('keyup','#buscar_proveedor',function(){
        let valor=$(this).val();
        if(valor!=''){
            buscar_prov(valor);
        }
        else{
            buscar_prov();
        }
    });
    $(document).on('click','.avatar',(e)=>{
        funcion="cambiar_logo";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('provId');
        const nombre =$(elemento).attr('provNombre');
        const avatar=$(elemento).attr('provAvatar');
        $('#logoactual').attr('src',avatar);
        $('#nombre_logo').html(nombre);
        $('#id_logo_prov').val(id);
        $('#funcion').val(funcion);
        $('#avatar').val(avatar);
    });
    $(document).on('click','.editar',(e)=>{
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id=$(elemento).attr('provId');
        const nombre =$(elemento).attr('provNombre');
        const direccion=$(elemento).attr('provDireccion');
        const telefono=$(elemento).attr('provTelefono');
        const correo=$(elemento).attr('provCorreo');
        $('#id_edit_prov').val(id);
        $('#nombre').val(nombre);
        $('#direccion').val(direccion);
        $('#telefono').val(telefono);
        $('#correo').val(correo);
        edit=true;
    });
    $('#form-logo').submit(e=>{
        let formData = new FormData($('#form-logo')[0]);
        $.ajax({
            url:'../controlador/proveedorController.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            contentType:false
        }).done(function(response){
            const json = JSON.parse(response);
            if(json.alert=='edit'){
                $('#logoactual').attr('src',json.ruta);
                $('#edit-prov').hide('slow');
                $('#edit-prov').show(1000);
                $('#edit-prov').hide(2000);
                $('#form-logo').trigger('reset');
                buscar_prov();
            }
            else{
                $('#noedit-prov').hide('slow');
                $('#noedit-prov').show(1000);
                $('#noedit-prov').hide(2000);
                $('#form-logo').trigger('reset');
            }
        });
        e.preventDefault();
    });

    $(document).on('click','.borrar',(e)=>{
        funcion="borrar";
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('provId');
        const nombre = $(elemento).attr('provNombre');
        const avatar = $(elemento).attr('provAvatar');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger mr-1"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: '¿Desea eliminar el proveedor '+nombre+'?',
            text: "No podrá revertir esta acción!",
            imageUrl:''+avatar+'',
            imageWidth:100,
            imageHeight:100, 
            showCancelButton: true,
            confirmButtonText: "Si, eliminar proveedor!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.post('../controlador/proveedorController.php',{id,funcion},(response)=>{
                    if(response=='borrado'){
                        swalWithBootstrapButtons.fire(
                            "Borrado!",
                            'El proveedor '+nombre+' fue borrado.',
                            'success'                       
                        ) 
                        buscar_prov();
                    }
                    else{
                        swalWithBootstrapButtons.fire(
                            "No se pudo borrar",
                            'El proveedor '+nombre+' no fue borrado',
                            'error'                  
                        )
                    }
                })
            }else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                "Cancelado",
                'El proveedor '+nombre+' no fué borrado',
                "error"
            )
            }
        })
    })
});