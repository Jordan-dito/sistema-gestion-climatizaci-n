<?php
//============================================================+
//
//============================================================+

/**
 *
 */


// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');
require_once('../app/TCPDF-main/tcpdf.php');
include('../app/config.php');

include('../app/controllers/ventas/literal.php');

session_start();
if(isset($_SESSION['sesion_email'])){
    // echo "si existe sesion de ".$_SESSION['sesion_email'];
    $email_sesion = $_SESSION['sesion_email'];
    $sql = "SELECT us.id_usuario as id_usuario, us.nombres as nombres, us.email as email, rol.rol as rol 
                  FROM tb_usuarios as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol WHERE email='$email_sesion'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as $usuario){
        $id_usuario_sesion = $usuario['id_usuario'];
        $nombres_sesion = $usuario['nombres'];
        $rol_sesion = $usuario['rol'];
    }
}else{
    echo "no existe sesion";
    header('Location: '.$URL.'/login');
}



$id_venta_get = $_GET['id_venta'];
$nro_venta_get = $_GET['nro_venta'];


$sql_ventas = "SELECT *, cli.nombre_cliente as nombre_cliente , cli.nit_ci_cliente as nit_ci_cliente
FROM tb_ventas as ve INNER JOIN tb_clientes as cli ON cli.id_cliente =ve.id_cliente where ve.id_venta='$id_venta_get' ";
                
$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute();
$ventas_datos = $query_ventas->fetchAll(PDO::FETCH_ASSOC);


foreach ($ventas_datos as $ventas_dato)
{
    $fyh_creacion=$ventas_dato['fyh_creacion'];
    $nit_ci_cliente=$ventas_dato['nit_ci_cliente'];
    $nombre_cliente=$ventas_dato['nombre_cliente'];
    $total_pagado=$ventas_dato['total_pagado'];
}

//convierte precio total a literal
$monto_literal = numtoletras($total_pagado);


$fecha= date("d/m/Y",strtotime($fyh_creacion));

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(215,279), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Hermanos Frios');
$pdf->setTitle('Factura de venta Hermanos Frios');
$pdf->setSubject('Factura de venta');
$pdf->setKeywords('Factura de venta');

// set default header data
//$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setMargins(15, 15, 15);
//$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
//$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$pdf->setFont('dejavusans', '', 14, '', true);
$pdf->setFont('Helvetica', '', '12');

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
//$html = <<<EOD
//<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
//<i>This is the first example of TCPDF library.</i>
//<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
//<p>Please check the source code documentation and other examples for further information.</p>
//<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
//EOD;
$html = '
<table border="0" style="font-size:10px">
<tr>
    <td style="text-align:center;width:230px">
        <img src="../public/images/icono/icono-negro.jpg" width="80px" alt=""> <br><br>

        <B>SISTEMA DE HERMANOS FRIOS</B><br>
        Guayaquil Norte Av. #123 <br>
        256688 - 0999639651 <br>
        GUAYAQUIL - ECUADOR
        </td>
    <td style="width:150px"></td>
        <td style="font-size:16px;width:290px"><br><br><br>
        <b>RUC: </b>1235568558 <br>
        <b>Nro factura: </b> '.$id_venta_get.' <br>
        <b>Nro de autorizacion: </b>132468886 
        <p style="text-align:center"><b>ORIGINAL</b> </p>


    </td>
</tr>

</table>
<p style="text-align:center;font-size:25px"><b>FACTURA</b></p>

<div style="border: 1px solid #000000">
<table border="0" cellpadding="6px">
<tr>
    <td><b>Fecha: </b> '.$fecha.'</td>
    <td></td>
    <td><b>Ruc/CI: </b>'.$nit_ci_cliente.'</td>
</tr>

<tr>
<td colspan="3"><b>Señor(es): </b>'.$nombre_cliente.'</td>
</tr>
</table>
</div>

<br><br>

<table border="1" cellpadding="5" style="font-size:12px">
<tr style="text-align:center;background-color:#d6d6d6">
    <th style="width:40px"><b>Nro</b></th>
    <th style="width:150px"><b>Producto</b></th>
    <th style="width:235px"><b>Descripcion</b></th>
    <th style="width:65px"><b>Cantidad</b></th>
    <th style="width:98px"><b>Precio Unitario</b></th>
    <th style="width:69px"><b>Sub total</b></th>
</tr>
';
$contador_de_carrito = 0;
$cantidad_total = 0;
$precio_unitario_total = 0;
$precio_total = 0;
$precio_iva = 0;
$iva = 0.15;
$precio_total_iva = 0;

//$sql_carrito = "SELECT *,pro.nombre as nombre_producto, pro.descripcion as descripcion , pro.precio_venta as precio_venta FROM tb_carrito AS carr INNER JOIN tb_almacen as pro ON carr.id_producto= pro.id_producto WHERE nro_venta='$nro_venta' ";
$sql_carrito = "SELECT *,pro.nombre as nombre_producto, 
pro.descripcion as descripcion , pro.precio_venta as precio_venta ,pro.stock as stock, pro.id_producto as id_producto FROM tb_carrito AS carr 
INNER JOIN tb_almacen as pro ON carr.id_producto= pro.id_producto
WHERE nro_venta='$nro_venta_get' ORDER BY id_carrito ASC ";

$query_carrito = $pdo->prepare($sql_carrito);
$query_carrito->execute();
$carrito_datos = $query_carrito->fetchAll(PDO::FETCH_ASSOC);

foreach ($carrito_datos as $carrito_dato) {

    $id_carrito = $carrito_dato['id_carrito'];
    $contador_de_carrito = $contador_de_carrito + 1;
    $cantidad_total = $cantidad_total + $carrito_dato['cantidad'];
    $precio_unitario_total = $precio_unitario_total + floatval($carrito_dato['precio_venta']);

    $subtotal= floatval($carrito_dato['cantidad']) * floatval($carrito_dato['precio_venta']);
    $precio_total=$precio_total+$subtotal;

   
  
    $html.='
    <tr>
        <td style="text-align:center">'.$contador_de_carrito.'</td>
        <td>'.$carrito_dato['nombre_producto'].'</td>
        <td>'.$carrito_dato['descripcion'].'</td>
        <td style="text-align:center">'.$carrito_dato['cantidad'] .'</td>
        <td style="text-align:center">$. '.number_format(floatval($carrito_dato['precio_venta']), 2) .'</td>
        <td style="text-align:center">$. '. number_format($subtotal, 2).'</td> 
    </tr>
    ';
}

$precio_iva = $precio_total * $iva;
$precio_total_iva = $precio_total + $precio_iva;

$html .='

<tr style="background-color:">
    <td colspan="3" style="text-align: right;background-color:#d6d6d6"><b>Total</b></td>
    <td style="text-align:center;background-color:#d6d6d6">'.$cantidad_total.'</td>
    <td style="text-align:center;background-color:#d6d6d6">$ '.number_format($precio_unitario_total, 2).'</td>
    <td style="text-align:center;background-color:#d6d6d6">$ '.number_format($precio_total, 2).'</td>
</tr>

<tr style="background-color:">
    <td colspan="3" style="text-align: right;background-color:#d6d6d6"><b>Iva(15%)*</b></td>
    <td style="text-align:center;background-color:#d6d6d6">'.$cantidad_total.'</td>
    <td style="text-align:center;background-color:#d6d6d6">$ '.number_format($precio_unitario_total, 2).'</td>
    <td style="text-align:center;background-color:#d6d6d6">$ '. number_format($precio_iva, 2).'</td>
</tr>

<tr style="background-color:">
    <td colspan="3" style="text-align: right;background-color:#d6d6d6"><b>Total con iva (15%)</b></td>
    <td style="text-align:center;background-color:#d6d6d6">'.$cantidad_total.'</td>
    <td style="text-align:center;background-color:#d6d6d6">$ '.number_format($precio_unitario_total, 2).'</td>
    <td style="text-align:center;background-color:#d6d6d6">$ '.number_format($precio_total_iva, 2).'</td>
</tr>
</table>

<p style="text-align:right">
    <b>Monto total: </b> $. '.number_format($precio_total_iva, 2).'
    </p>
        <b>Son: </b> '.$monto_literal.' $.
    </p>

    ------------------------------------------------------------------------<br>

    <b>USUARIO:</B> '.$email_sesion .' <br>
    
    <p style="text-align:center">"ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS, EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LA LESGIGACION"
    </p>
    <p style="text-align:center"><b>GRACIAS POR SU PREFERENCIA</b></p>



';

// Print text using writeHTMLCell()
//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->writeHTML($html, true, false, true, false, '');


$style = array(
    'border' => 0,
    'vpadding' => '3',
    'hpadding' => '3',
    'fgcolor' => array(0,0,0),
    'bgcolor' => array(255,255,255),
    'module_width' => 1,
    'module_height' => 1

);

$QR= 'Factura realizada por el sistema de hermanos frios web, al cliente '.$nombre_cliente.' con ru/cedula: '.$nit_ci_cliente.'
en fecha '.$fecha.' con el monto total de '.$precio_total.' ';
$pdf->write2DBarcode($QR,'QRCODE,L',170,240,40,40,$style);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
//$pdf->Output('example_001.pdf', 'I');
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
