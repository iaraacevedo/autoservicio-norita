<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Admin\ProductoController as AdminController;

// Ruta principal: Catálogo de productos
Route::get('/', [TiendaController::class, 'index'])->name('tienda.index');

// Ruta para ver un producto individual
Route::get('/producto/{id}', [TiendaController::class, 'show'])->name('tienda.show');

// Rutas del Carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.add');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.remove');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.clear');

// Ruta para finalizar compra
Route::post('/pedido/confirmar', [PedidoController::class, 'confirmar'])
    ->name('pedido.confirmar')
    ->middleware('auth');

// NUEVA RUTA: Pago en Efectivo
Route::post('/pedido/confirmar-efectivo', [App\Http\Controllers\PedidoController::class, 'confirmarEfectivo'])
    ->name('pedido.confirmar_efectivo')
    ->middleware('auth');

// Ruta para que el cliente vea sus compras
Route::get('/mis-pedidos', [App\Http\Controllers\PedidoController::class, 'misPedidos'])->name('tienda.mis_pedidos')->middleware('auth');

// Grupo de rutas para el Administrador
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rutas de Categorías
    Route::resource('categorias', App\Http\Controllers\Admin\CategoriaController::class)->names('admin.categorias');

    // Rutas de Productos (CRUD Completo)
    Route::resource('productos', App\Http\Controllers\Admin\ProductoController::class)->names('admin.productos');

    // Ruta especial para Ocultar/Mostrar sin borrar
    Route::get('productos/{id}/visibilidad', [App\Http\Controllers\Admin\ProductoController::class, 'toggleVisibility'])->name('admin.productos.toggle');
    // Ruta para cambiar estado del pedido y enviar mail
    Route::put('/pedidos/{id}/estado', [App\Http\Controllers\Admin\PedidoAdminController::class, 'actualizarEstado'])
        ->name('admin.pedidos.update_estado');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
