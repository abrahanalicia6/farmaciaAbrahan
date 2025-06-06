<?php
session_start();
if ($_SESSION['us_tipo']==3||$_SESSION['us_tipo']==1) {
    include_once 'layouts/header.php';

?>
<title>Adm | Gestión ventas</title>
<!-- Tell the browser to be responsive to screen width -->
<?php
include_once 'layouts/nav.php';

?>
<div class="modal fade" id="vista_venta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Registros de ventas</h3>
                <button data-dismiss="modal" aria-label="close"class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="codigo_venta">Código venta: </label>
                    <span id="codigo_venta"></span>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha: </label>
                    <span id="fecha"></span>
                </div>
                <div class="form-group">
                    <label for="cliente">Cliente: </label>
                    <span id="cliente"></span>
                </div>
                <div class="form-group">
                    <label for="dni">DNI: </label>
                    <span id="dni"></span>
                </div>
                <div class="form-group">
                    <label for="vendedor">Vendedor: </label>
                    <span id="vendedor"></span>
                </div>
                <table class="table table-hover text-nowrap">
                    <thead class="table-secondary">
                        <tr>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Producto</th>
                            <th>Concentracion</th>
                            <th>Adicional</th>
                            <th>Laboratorio</th>
                            <th>Presentacion</th>
                            <th>Tipo</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="table-warning"id="registros"></tbody>
                </table>
                <div class="float-right input-group-append">
                    <h3 class="m-3">Total: </h3>
                    <h3 class="m-3"id="total"></h3>
                </div>
            </div>
            <div class="card-footer">
                
                <button type="button" data-dismiss="modal"class="btn btn-outline-secondary float-right m-1">Cerrar</button>
            </div>
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
            <h1>Gestión ventas</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
            <li class="breadcrumb-item active">Gestión ventas</li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>
    <section>
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Buscar ventas</h3>
                </div>
                <div class="card-body">
                <table id="tabla_venta" class="display table table-hover text-nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>DNI.</th>
                <th>Total</th>
                <th>Vendedor</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
                </div>
                <div class="card-footer">
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
<script src="../js/venta.js"></script>
<script src="../js/datatables.js"></script>