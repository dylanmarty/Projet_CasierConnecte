<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdherentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpruntsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\CasierController;
use App\Http\Controllers\FamilleMaterielController;

Route::get('/', function () {
    return view('welcome');
})->name('accueil');
Route::get('/', [CasierController::class, 'index']);

Route::get('/historique', [EmpruntsController::class, 'getEmprunts'])->name('historique.index');
Route::post('/envoyer-message', [EmpruntsController::class, 'sendMessage'])->name('envoyer-message');

Route::get('/utilisateur', [UsersController::class, 'getUtilisateurs']);
Route::put("updateUtilisateur/{id}", [UsersController::class, 'updateUtilisateur']);
Route::get("deleteUtilisateur/{id}", [UsersController::class, 'deleteUtilisateur']);
Route::post("deleteAllUtilisateur", [UsersController::class, 'deleteAllUtilisateur']);

Route::get("/adherent", [AdherentController::class, 'getAdherent']);
Route::get("deleteAdherent/{id}", [AdherentController::class, 'deleteAdherent']);
Route::post("deleteAllAdherent", [AdherentController::class, 'deleteAllAdherent']);
Route::put("updateAdherent/{id}", [AdherentController::class, 'updateAdherent']);
Route::post("addAdherent", [AdherentController::class, 'addAdherent']);
Route::post("importAdherent", [AdherentController::class, 'importAdherent']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/materiel", [MaterielController::class, 'getMateriel']);
Route::get('/filtrer-materiels', [MaterielController::class, 'filtrerMateriels']);
Route::post("addMateriel", [MaterielController::class, 'addMateriel']);
Route::put("updateMateriel/{id}", [MaterielController::class, 'updateMateriel']);
Route::get("deleteMateriel/{id}", [MaterielController::class, 'deleteMateriel']);
Route::post("deleteAllMateriel", [MaterielController::class, 'deleteAllMateriel']);

Route::get("/familleMateriel", [FamilleMaterielController::class, 'getFamille']);
Route::post("addFamille", [FamilleMaterielController::class, 'addFamille']);
Route::post("deleteAllFamille", [FamilleMaterielController::class, 'deleteAllFamille']);
Route::put("updateFamille/{id}", [FamilleMaterielController::class, 'updateFamille']);
Route::get("deleteFamille/{id}", [FamilleMaterielController::class, 'deleteFamille']);

Route::get('/confidentialite', function () {
    return view('confidentialite');
})->name('confidentialite');

Route::get('/conditions', function () {
    return view('conditions');
})->name('conditions');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

require __DIR__.'/auth.php';
