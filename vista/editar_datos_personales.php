<?php
session_start();
if ($_SESSION['us_tipo'] == 1||$_SESSION['us_tipo']==3) {
  include_once 'layouts/header.php';
?>
  <title>Adm | Editar Datos</title>
  <!-- Tell the browser to be responsive to screen width -->
<?php
include_once 'layouts/nav.php';
?>
<div class="modal fade" id="cambiocontra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar contraseña</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="avatar3"src="../img/avatar1.jpg" class="profile-user-img img-fluid img-circle">
        </div>
        <div class="text-center">
          <b>
              <?php
            echo $_SESSION['nombre_us'];
            ?>
          </b>
        </div>
        <div class="alert alert-success text-center" id="update" style='display:none;'>
        <span><i class="fas fa-check m-1"></i>La contraseña se cambió correctamente</span>
        </div>
        <div class="alert alert-danger text-center" id="noupdate" style='display:none;'>
        <span><i class="fas fa-times m-1"></i>La contraseña no es correcta</span>
        </div>
        <form id="form-pass">
          <div class="input-group mb-3">
          <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
          </div>
          <input id="oldpass"type="password" class="form-control" placeholder="Ingrese contraseña actual">
          </div>
          <div class="input-group mb-3">
          <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          </div>
          <input id="newpass"type="text" class="form-control" placeholder="Ingrese contraseña nueva">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cambiophoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar avatar</h1>
        <button type="button"class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="avatar1"src="../img/avatar1.jpg" class="profile-user-img img-fluid img-circle">
        </div>
        <div class="text-center">
          <b>
            <?php
                echo $_SESSION['nombre_us'];
            ?>
          </b>
        </div>
        <div class="alert alert-success text-center" id="edit" style='display:none;'>
        <span><i class="fas fa-check m-1"></i>Se cambio el avatar</span>
        </div>
        <div class="alert alert-danger text-center" id="noedit" style='display:none;'>
        <span><i class="fas fa-times m-1"></i>La imagen no es compatible</span>
        </div>
        <form id="form-photo" enctype="multipart/form-data">
          <div class="input-group mb-3 ml-5 mt-2">
            <input type="file" name="photo"class="input-group">
            <input type="hidden" name="funcion" value="cambiar_foto">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Datos personales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Datos personales</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class=" card card-secondary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img id='avatar2'src="../img/avatar1.jpg" class="profile-user-img img-fluid img-circle">
                                </div>
                                <div class="text-center mt-1">
                                  <button type="button" data-toggle="modal" data-target="#cambiophoto" class="btn bg-gradient-orange btn-sm">Cambiar avatar</button>
                                </div>
                              <input id="id_usuario"type="hidden" value="<?php echo $_SESSION['usuario']?>">
                                <h3 id="nombre_us"class="profile-username text-center text-black">Alicia</h3>
                                <p id="apellido_us"class="text-muted text-center">Abrahan</p>
                                  <ul class="list-group list-group-unbordered mb-3">
                                      <li class="list-group-item">
                                          <b style="color:#1B5E20">Edad</b><a id="edad"class="float-right">28</a>
                                      </li>
                                      <li class="list-group-item">
                                          <b style="color:#1B5E20">DNI</b><a id="dni_us"class="float-right">22594398</a>
                                      </li>
                                      <li class="list-group-item">
                                          <b style="color:#1B5E20">Tipo Usuario</b>
                                          <span id="us_tipo"class="float-right badge badge-success">Root</span>
                                      </li>
                                        <button data-toggle="modal" data-target="#cambiocontra" type="button" class="btn btn-block bg-gradient-orange btn-sm">Cambiar contraseña</button>
                                    </ul>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Sobre mi</h3>
                            </div>
                            <div class="card-body">
                                <strong style="color:#1B5E20">
                                    <i class="fas fa-phone mr-1"></i>Telefono
                                </strong>
                                <p id='telefono_us'class="text-muted">3482279276</p>
                                <strong style="color:#1B5E20">
                                    <i class="fas fa-location-dot"></i>Localidad
                                </strong>
                                <p id="localidad_us"class="text-muted">Reconquista</p>
                                <strong style="color:#1B5E20">
                                    <i class="fas fa-home"></i>Direccion
                                </strong>
                                <p id="direccion_us"class="text-muted">Calle 67 123</p>
                                <strong style="color:#1B5E20">
                                    <i class="fas fa-at mr-1"></i>Correo
                                </strong>
                                <p id="correo_us"class="text-muted">abrahanalicia76@gmail.com</p>
                                <strong style="color:#1B5E20">
                                    <i class="fas fa-venus-mars mr-1"></i>Sexo
                                </strong>
                                <p id="sexo_us"class="text-muted">Femenino</p>
                                <strong style="color:#1B5E20">
                                    <i class="fas fa-info-circle mr-1"></i>Informacion adicional
                                </strong>
                                <p id="adicional_us"class="text-muted">Programadora</p>
                                <button class="edit btn btn-block bg-gradient-danger">Editar</button>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted">Click en el boton si desea editar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                      <div class=" card card-secondary">
                        <div class="card-header">
                          <h3 class="card-title">Editar datos personales</h3>
                        </div>
                        <div class="card-body">
                          <div class="alert alert-success text-center" id="editado" style='display:none;'>
                              <span><i class="fas fa-check m-1"></i>Editado</span>
                          </div>
                          <div class="alert alert-danger text-center" id="noeditado" style='display:none;'>
                              <span><i class="fas fa-times m-1"></i>Edicion deshabilitada</span>
                          </div>
                          <form id='form-usuario'class="form-horizontal">
                            <div class="form-group row">
                              <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                              <div class="col-sm-10">
                              <input type="number" id="telefono" class="form-control">
                            </div>
                            </div>
                            <div class="form-group row">
                              <label for="localidad" class="col-sm-2 col-form-label">Localidad</label>
                              <div class="col-sm-10">
                              <input type="text" id="localidad" class="form-control">
                            </div>
                            </div>
                            <div class="form-group row">
                              <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                              <div class="col-sm-10">
                              <input type="text" id="direccion" class="form-control">
                            </div>
                            </div>
                            <div class="form-group row">
                              <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                              <div class="col-sm-10">
                              <input type="text" id="correo" class="form-control">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="sexo" class="col-sm-2 col-form-label">Sexo</label>
                              <div class="col-sm-10">
                              <input type="text" id="sexo" class="form-control">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="adicional" class="col-sm-2 col-form-label">Información adicional</label>
                              <div class="col-sm-10">
                              <textarea class="form-control" id="adicional"></textarea>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="offset-sm-2 col-sm-10 float-right">
                                <button class="btn btn-block btn-outline-primary">Guardar</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="card-footer">
                          <p class="text-muted">Por favor, asegúrese de que los datos ingresados sean correctos</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>
  <!-- /.content-wrapper --> 
<?php
include_once 'layouts/footer.php';
}
else{
  header('Location: ../index.php');
}
?>
<script src="../js/usuario.js"></script>