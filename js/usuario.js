$(document).ready(function(){
    var funcion = '';
    var id_usuario = $('#id_usuario').val();
    var edit=false;
    buscar_usuario(id_usuario);
    function buscar_usuario(dato) {
        funcion='buscar_usuario';
        $.post('../controlador/usuarioController.php',{dato, funcion},(response)=>{
            let nombre='';
            let apellido='';
            let edad='';
            let dni='';
            let sexo='';
            let tipo='';
            let telefono='';
            let localidad='';
            let direccion='';
            let correo='';
            let adicional='';
            const usuario = JSON.parse(response);
            nombre+=`${usuario.nombre}`;
            apellido+=`${usuario.apellido}`;
            edad+=`${usuario.edad}`;
            dni+=`${usuario.dni}`;
            sexo+=`${usuario.sexo}`;
            if(usuario.tipo=='Root'){
                tipo+=`<h1 class="badge badge-danger">${usuario.tipo}</h1>`;
            }
            if(usuario.tipo=='Administrador'){
                tipo+=`<h1 class="badge badge-warning">${usuario.tipo}</h1>`;
            }
            if(usuario.tipo=='Tecnico'){
                tipo+=`<h1 class="badge badge-info">${usuario.tipo}</h1>`;
            }
            telefono+=`${usuario.telefono}`;
            localidad+=`${usuario.localidad}`;
            direccion+=`${usuario.direccion}`;
            correo+=`${usuario.correo}`;
            adicional+=`${usuario.adicional}`;
            $('#nombre_us').html(nombre);
            $('#apellido_us').html(apellido);
            $('#edad').html(edad);
            $('#dni_us').html(dni);
            $('#us_tipo').html(tipo);
            $('#sexo_us').html(sexo);
            $('#telefono_us').html(telefono);
            $('#localidad_us').html(localidad);
            $('#direccion_us').html(direccion);
            $('#correo_us').html(correo);
            $('#adicional_us').html(adicional);
            
            $('#avatar2').attr('src',usuario.avatar);
            $('#avatar1').attr('src',usuario.avatar);
            $('#avatar3').attr('src',usuario.avatar);
            $('#avatar4').attr('src',usuario.avatar);
        })
    }   
    $(document).on('click','.edit',(e)=>{
        funcion='capturar_datos';
        edit=true;
        $.post('../controlador/usuarioController.php',{funcion,id_usuario},(response)=>{
            const usuario = JSON.parse(response);
            $('#telefono').val(usuario.telefono);
            $('#localidad').val(usuario.localidad);
            $('#direccion').val(usuario.direccion);
            $('#correo').val(usuario.correo);
            $('#sexo').val(usuario.sexo);
            $('#adicional').val(usuario.adicional);
        })
    });
    $('#form-usuario').submit(e=>{
        if(edit==true){
            let telefono=$('#telefono').val();
            let localidad=$('#localidad').val();
            let direccion=$('#direccion').val();
            let correo=$('#correo').val();
            let sexo=$('#sexo').val();
            let adicional=$('#adicional').val();
            funcion='editar_usuario';
            $.post('../controlador/usuarioController.php',{id_usuario,funcion,telefono,localidad,direccion,correo,sexo,adicional},(response)=>{
                if(response=='editado'){
                    $('#editado').hide('slow');
                    $('#editado').show(1000);
                    $('#editado').hide(2000);
                    $('#form-usuario').trigger('reset');
                }
                    edit=false;
                    buscar_usuario(id_usuario);
            })
        }
        else{
            $('#noeditado').hide('slow');
            $('#noeditado').show(1000);
            $('#noeditado').hide(2000);
            $('#form-usuario').trigger('reset');
        }
        e.preventDefault();
    });
    $('#form-pass').submit(e=>{
        let oldpass=$('#oldpass').val();
        let newpass=$('#newpass').val();
        funcion='cambiar_contra';
        $.post('../controlador/usuarioController.php',{id_usuario,funcion,oldpass,newpass},(response)=>{
            if(response=='update'){
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-pass').trigger('reset');
            }
            else{
                $('#noupdate').hide('slow');
                $('#noupdate').show(1000);
                $('#noupdate').hide(2000);
                $('#form-pass').trigger('reset');
            }
        })
        e.preventDefault();
    })
    $('#form-photo').submit(e=>{
        let formData = new FormData($('#form-photo')[0]);
        $.ajax({
            url:'../controlador/usuarioController.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            contentType:false
        }).done(function(response){
            const json= JSON.parse(response);
            if(json.alert=='edit'){
                $('#avatar1').attr('src',json.ruta);
                $('#edit').hide('slow');
                $('#edit').show(1000);
                $('#edit').hide(2000);
                $('#form-photo').trigger('reset');
                funcion='buscar_usuario';
            }
            else{
                $('#noedit').hide('slow');
                $('#noedit').show(1000);
                $('#noedit').hide(2000);
                $('#form-photo').trigger('reset');
            }
        });
        e.preventDefault();
    })
})