<?php
// ../app/controllers/almacen/kardex_fifo_controller.php
// Nota: NO incluir config aquí. Este archivo solo define la función.
// Asegúrate de que la vista que lo usa ya incluyó app/config.php
// y tiene $conexion (mysqli).

if (!function_exists('get_kardex_fifo')) {

    /**
     * Calcula el kardex FIFO para un producto.
     *
     * @param mysqli $conexion   Conexión mysqli válida (desde config.php)
     * @param int    $id_producto
     * @return array             Arreglo de filas para mostrar en el Kardex
     * @throws Exception
     */
    function get_kardex_fifo(mysqli $conexion, int $id_producto): array {

        // Opción A (precio_compra ya es DECIMAL unitario):
        $sql = "
            SELECT
                tc.fyh_creacion AS fecha,
                'IN'            AS tipo,
                tc.cantidad     AS cantidad,
                tc.precio_compra AS costo_unitario,
                CONCAT('Compra #', tc.id_compra) AS documento,
                tc.id_compra    AS id_mov
            FROM tb_compras tc
            WHERE tc.id_producto = ?

            UNION ALL

            SELECT
                v.fyh_creacion  AS fecha,
                'OUT'           AS tipo,
                c.cantidad      AS cantidad,
                NULL            AS costo_unitario,
                CONCAT('Venta #', v.id_venta) AS documento,
                v.id_venta      AS id_mov
            FROM tb_ventas v
            JOIN tb_carrito c ON v.nro_venta = c.nro_venta
            WHERE c.id_producto = ?
            ORDER BY fecha ASC,
                     (CASE WHEN tipo = 'IN' THEN 0 ELSE 1 END) ASC,
                     id_mov ASC
        ";

        /*  --- Opción B (si guardas precio_total e IVA y quieres costo unitario sin IVA) ---
        $sql = "
            SELECT
                tc.fyh_creacion AS fecha,
                'IN'            AS tipo,
                tc.cantidad     AS cantidad,
                (CASE 
                    WHEN tc.cantidad > 0 THEN 
                        (tc.precio_total / tc.cantidad) / (1 + (tc.iva/100))
                    ELSE 0
                 END)           AS costo_unitario,
                CONCAT('Compra #', tc.id_compra) AS documento,
                tc.id_compra    AS id_mov
            FROM tb_compras tc
            WHERE tc.id_producto = ?

            UNION ALL
            SELECT
                v.fyh_creacion  AS fecha,
                'OUT'           AS tipo,
                c.cantidad      AS cantidad,
                NULL            AS costo_unitario,
                CONCAT('Venta #', v.id_venta) AS documento,
                v.id_venta      AS id_mov
            FROM tb_ventas v
            JOIN tb_carrito c ON v.nro_venta = c.nro_venta
            WHERE c.id_producto = ?
            ORDER BY fecha ASC,
                     (CASE WHEN tipo = 'IN' THEN 0 ELSE 1 END) ASC,
                     id_mov ASC
        ";
        */

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando consulta: " . $conexion->error);
        }
        $stmt->bind_param('ii', $id_producto, $id_producto);

        if (!$stmt->execute()) {
            $err = $stmt->error ?: $conexion->error;
            $stmt->close();
            throw new Exception("Error ejecutando consulta: " . $err);
        }

        $movs = [];
        if (method_exists($stmt, 'get_result')) {
            $res = $stmt->get_result();
            $movs = $res->fetch_all(MYSQLI_ASSOC);
        } else {
            $stmt->bind_result($r_fecha, $r_tipo, $r_cantidad, $r_costo_unitario, $r_documento, $r_id_mov);
            while ($stmt->fetch()) {
                $movs[] = [
                    'fecha'          => $r_fecha,
                    'tipo'           => $r_tipo,
                    'cantidad'       => $r_cantidad,
                    'costo_unitario' => $r_costo_unitario,
                    'documento'      => $r_documento,
                    'id_mov'         => $r_id_mov,
                ];
            }
        }
        $stmt->close();

        // --- Motor FIFO ---
        $layers = [];            // cada capa: ['qty' => float, 'cost' => float]
        $saldo_qty   = 0.0;
        $saldo_valor = 0.0;

        $kardex_rows = [];

        foreach ($movs as $m) {
            $fecha     = $m['fecha'];
            $documento = $m['documento'];
            $tipo      = $m['tipo'];
            $cantidad  = (float)$m['cantidad'];

            $row = [
                'fecha'            => $fecha,
                'documento'        => $documento,
                'entrada_cant'     => 0,
                'entrada_cost'     => 0,
                'entrada_total'    => 0,
                'salida_cant'      => 0,
                'salida_cost_unit' => 0,
                'salida_total'     => 0,
                'saldo_cant'       => 0,
                'saldo_cost_unit'  => 0,
                'saldo_total'      => 0,
            ];

            if ($tipo === 'IN') {
                $cost_unit = (float)$m['costo_unitario'];
                $layers[] = ['qty' => $cantidad, 'cost' => $cost_unit];

                $entrada_total = $cantidad * $cost_unit;
                $saldo_qty   += $cantidad;
                $saldo_valor += $entrada_total;

                $row['entrada_cant']  = $cantidad;
                $row['entrada_cost']  = $cost_unit;
                $row['entrada_total'] = $entrada_total;

            } else { // OUT
                $qty_out = $cantidad;
                $cogs    = 0.0;

                while ($qty_out > 0 && count($layers) > 0) {
                    $available = $layers[0]['qty'];
                    $consume   = min($available, $qty_out);
                    $cogs     += $consume * $layers[0]['cost'];
                    $layers[0]['qty'] = $available - $consume;

                    if (abs($layers[0]['qty']) < 1e-9) $layers[0]['qty'] = 0;
                    $qty_out -= $consume;
                    if ($layers[0]['qty'] <= 0) array_shift($layers);
                }

                // Si no había stock suficiente (qty_out > 0), las unidades faltantes salen con costo 0 (política simple)
                $saldo_qty   -= $cantidad;
                $saldo_valor -= $cogs;

                $row['salida_cant']      = $cantidad;
                $row['salida_cost_unit'] = $cantidad > 0 ? ($cogs / $cantidad) : 0;
                $row['salida_total']     = $cogs;
            }

            $row['saldo_cant']      = $saldo_qty;
            $row['saldo_total']     = $saldo_valor;
            $row['saldo_cost_unit'] = $saldo_qty != 0 ? ($saldo_valor / $saldo_qty) : 0;

            $kardex_rows[] = $row;
        }

        return $kardex_rows;
    }
}
?>