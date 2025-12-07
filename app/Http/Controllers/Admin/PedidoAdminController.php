<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoListoMailable;

class PedidoAdminController extends Controller
{
    // Función para cambiar el estado del pedido
    public function actualizarEstado(Request $request, $id)
    {
        // 1. Buscamos el pedido por ID
        $pedido = Pedido::findOrFail($id);

        // 2. Guardamos el nuevo estado que viene del formulario (ej: 'listo', 'entregado')
        $pedido->estado = $request->estado;
        $pedido->save();

        $mensaje = "Estado actualizado a: " . ucfirst($request->estado);

        // 3. SI EL ESTADO ES "LISTO", ENVIAMOS CORREO
        if ($request->estado == 'listo') {
            try {
                // Enviamos el mail al usuario dueño del pedido
                Mail::to($pedido->user->email)->send(new PedidoListoMailable($pedido));
                $mensaje .= " (Correo enviado al cliente ✅)";
            } catch (\Exception $e) {
                // Si falla el correo (por ej. en local sin internet), avisamos pero no rompemos la página
                // Esto es importante para que el sistema no se trabe si falla Gmail
                $mensaje .= " (Atención: Estado cambiado, pero el correo no salió. Revisa tu .env)";
            }
        }

        // 4. Volvemos al Dashboard con el mensaje de éxito
        return redirect()->back()->with('success', $mensaje);
    }
}
