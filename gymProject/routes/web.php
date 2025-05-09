<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RutinaController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;


/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', fn() => view('home'))->name('home');

// About Us
Route::view('/about', 'about')->name('about');

// Selección de tipo de rutinas
Route::get('/rutinas', [RutinaController::class, 'index'])->name('rutinas.index');
Route::get('/rutinas/fuerza', [RutinaController::class, 'mostrarRutinasFuerza'])->name('rutinas.fuerza');
Route::get('/rutinas/alimentacion', [RutinaController::class, 'mostrarRutinasAlimentacion'])->name('rutinas.alimentacion');
Route::get('/rutinas/alimentacion/{id}', [RutinaController::class, 'mostrarDetalleAlimentacion'])->name('rutinas.alimentacion.detalle');

// Productos (tienda)
Route::get('/products', [ProductoController::class, 'index'])->name('products.index');
Route::get('/carrito', [App\Http\Controllers\CartController::class, 'show'])->name('cart.show');

// API endpoints
Route::get('/ejercicios/{bodyPart}', [EjercicioController::class, 'mostrarPorGrupo']);
Route::get('/planes', [PlanController::class, 'index'])->name('planes.index');

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register']);

// Tienda
Route::get('/products', [ProductoController::class, 'index'])->name('products.index');
Route::post('/cart/add',    [CartController::class, 'add'])->name('cart.add');
Route::get('/cart',         [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function(){
    // Dashboard y perfil
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile/edit', fn() => view('profile.edit',['user'=>auth()->user()]))->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::get('/perfil', [ProfileController::class, 'miPerfil'])->name('perfil');

    // Creación de rutinas/recetas
    Route::get('/rutinas/crear', [RutinaController::class, 'create'])->name('rutinas.create');
    Route::post('/rutinas', [RutinaController::class, 'store'])->name('rutinas.store');
    Route::get('/rutinas/{id}', [RutinaController::class, 'show'])->name('rutinas.show');
    Route::get('/rutinas/{id}/edit', [RutinaController::class, 'edit'])->name('rutinas.edit');
    Route::put('/rutinas/{id}', [RutinaController::class, 'update'])->name('rutinas.update');
    Route::delete('/rutinas/{id}', [RutinaController::class, 'destroy'])->name('rutinas.destroy');

    // Flujo de suscripción y pago
    Route::get('/suscribirse',           [SuscripcionController::class, 'formularioPago'])->name('suscripcion.formulario');
    Route::post('/suscribirse/procesar', [SuscripcionController::class, 'procesarPago'])->name('suscripciones.procesar');
    Route::get('/planes/actual',         [SuscripcionController::class, 'verPlanActual'])->name('planes.actual');
    Route::patch('/suscribirse/cancelar',[SuscripcionController::class, 'cancelar'])->name('suscripcion.cancelar');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
});
