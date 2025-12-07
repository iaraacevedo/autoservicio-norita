<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Cliente HTTP para Mercado Pago

class PedidoController extends Controller
{
    // 1. Mostrar historial de pedidos al cliente
    public function misPedidos()
    {
        $pedidos = Pedido::where('user_id', Auth::id())
            ->with('productos')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tienda.mis_pedidos', compact('pedidos'));
    }

    // 2. Procesar compra con MERCADO PAGO
    public function confirmar()
    {
        // A. Validaciones
        $carrito = session()->get('carrito');
        if (!$carrito) return redirect()->route('tienda.index')->with('success', 'El carrito está vacío.');
        if (!Auth::check()) return redirect()->route('login')->with('error', 'Inicia sesión para comprar.');

        // B. Calcular Total
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        DB::beginTransaction();
        try {
            // C. Guardar Pedido (Método Mercado Pago)
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'metodo_pago' => 'mercadopago',
                'estado' => 'pendiente'
            ]);

            // D. Guardar Detalles
            foreach ($carrito as $id => $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio']
                ]);
            }

            DB::commit();

            // -----------------------------------------------------
            // E. INTEGRACIÓN MERCADO PAGO
            // -----------------------------------------------------

            // TU TOKEN REAL DE PRODUCCIÓN
            $token = 'APP_USR-1759866531989155-120417-946aaa499d5e6399fe79766a51ebe6fb-3040726486';

            // Preparamos los ítems
            $items_mp = [];
            foreach ($carrito as $id => $item) {
                $items_mp[] = [
                    'id' => strval($id),
                    'title' => $item['nombre'],
                    'description' => 'Producto de Norita',
                    'quantity' => intval($item['cantidad']),
                    'currency_id' => 'ARS',
                    'unit_price' => floatval($item['precio'])
                ];
            }

            // paquete de datos
            $datos_mp = [
                'items' => $items_mp,
                'payer' => [
                    'email' => 'cliente_generico@testuser.com' // Email genérico para evitar bloqueos
                ],
                // USO DE ROUTE(): Esto genera el link correcto automáticamente sea donde sea que esté la web
                'back_urls' => [
                    'success' => route('tienda.mis_pedidos'),
                    'failure' => route('carrito.index'),
                    'pending' => route('tienda.index')
                ],
                'auto_return' => 'approved',
                'binary_mode' => true
            ];

            // Enviar a MP
            $response = Http::withToken($token)
                ->withoutVerifying()
                ->post('https://api.mercadopago.com/checkout/preferences', $datos_mp);

            if ($response->failed()) {
                session()->forget('carrito');
                return redirect()->route('tienda.mis_pedidos')
                    ->with('success', 'Pedido registrado. (Nota: El pago online no se inició por un error de conexión con MP).');
            }

            $link = $response->json()['init_point'];
            session()->forget('carrito');

            return redirect($link);
        } catch (\Exception $e) {
            DB::rollBack();
            return dd("ERROR DEL SISTEMA:", $e->getMessage());
        }
    }

    // 3. NUEVA FUNCIÓN: PAGO EN EFECTIVO (Sin Mercado Pago)
    public function confirmarEfectivo()
    {
        // A. Validaciones
        $carrito = session()->get('carrito');
        if (!$carrito) return redirect()->route('tienda.index')->with('success', 'El carrito está vacío.');

        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        DB::beginTransaction();
        try {
            // B. Guardar Pedido (Método Efectivo)
            $pedido = Pedido::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'metodo_pago' => 'efectivo', // <--- Lo marcamos como efectivo
                'estado' => 'pendiente'
            ]);

            // C. Guardar Detalles
            foreach ($carrito as $id => $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio']
                ]);
            }

            DB::commit();

            // D. Limpiar Carrito
            session()->forget('carrito');

            // E. Redirigir a "Mis Pedidos" con mensaje de éxito
            return redirect()->route('tienda.mis_pedidos')
                ->with('success', '¡Pedido registrado con éxito! Te esperamos en el local para abonar y retirar tu compra.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar el pedido: ' . $e->getMessage());
        }
    }
}
