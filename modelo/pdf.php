<?php
include_once 'venta.php';
include_once 'ventaProducto.php';
function getHtml($id_venta){
    $venta = new Venta();
    $venta_producto = new ventaProducto();
    $venta->buscar_id($id_venta);
    $venta_producto->ver($id_venta);
    $plantilla='
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="../img/logo.png" width="60" height="60">
            </div>
            <h1>Comprobante de pago</h1>
            <div id="company" class="clearfix">
                <div id="negocio">Farmacia Abrahan</div>
                <div>Direccion Bulevar Peron 1896,<br />Reconquista, Santa Fe</div>
                <div>(03482) 427072</div>
                <div><a href="mailto:abrahanfarmacia@gmail.com">abrahanfarmacia@gmail.com</a></div>
            </div>';
            foreach ($venta->objetos as $objeto){

            $plantilla.='
            
            <div id="project">
            <div><span>Código de venta: </span>'.$objeto->id_venta.'</div>
            <div><span>Cliente: </span>'.$objeto->cliente.'</div>
            <div><span>DNI: </span>'.$objeto->dni.'</div>
            <div><span>Fecha y hora: </span>'.$objeto->fecha.'</div>
            <div><span>Vendedor: </span>'.$objeto->vendedor.'</div>
            </div>';
            }
            $plantilla.='
        </header>
        <main>
            <table>
                <thead>
                    <tr>
                        <th class="service">Producto</th>
                        <th class="service">Concentración</th>
                        <th class="service">Adicional</th>
                        <th class="service">Laboratorio</th>
                        <th class="service">Presentación</th>
                        <th class="service">Tipo</th>
                        <th class="service">Cantidad</th>
                        <th class="service">Precio</th>
                        <th class="service">Subtotal</th>
                    </tr>
                </thead>
            <tbody>';

            foreach ($venta_producto->objetos as $objeto) {
                $plantilla.='<tr>

                <td class="servic">'.$objeto->producto.'</td>
                <td class="servic">'.$objeto->concentracion.'</td>
                <td class="servic">'.$objeto->adicional.'</td>
                <td class="servic">'.$objeto->laboratorio.'</td>
                <td class="servic">'.$objeto->presentacion.'</td>
                <td class="servic">'.$objeto->tipo.'</td>
                <td class="servic">'.$objeto->cantidad.'</td>
                <td class="servic">'.$objeto->precio.'</td>
                <td class="servic">'.$objeto->subtotal.'</td>
            </tr>';
            }
            $calculos = new Venta();
            $calculos->buscar_id($id_venta);
            foreach ($calculos->objetos as $objeto) {
                $iva=$objeto->total*0.21;
                $sub=$objeto->total-$iva;

                $plantilla.='
                <tr>
                    <td colspan="8" class="grand total">SUBTOTAL</td>
                    <td class="grand total">$'.$sub.'</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">IVA(21%)</td>
                    <td class="grand total">$'.$iva.'</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">TOTAL</td>
                    <td class="grand total">$'.$objeto->total.'</td>
                </tr>';
            }
            $plantilla.='
            </tbody>
            </table>
            <div id="notices">
                <div>INFORMACIÓN IMPORTANTE:</div>
                <div class="notices">Presentar este comprobante de pago para cualquier reclamo o devolución.</div>
                <div class="notices">El reclamo procedera las 24hrs de haber hecho la compra.</div>
            </div>
            </main>
            <footer>
            </footer>
            </body>';
            return $plantilla;
        }
    
    
    
    
    
    
    


