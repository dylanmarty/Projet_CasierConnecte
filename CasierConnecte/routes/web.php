<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdherentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpruntsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\CasierController;
use App\Http\Controllers\FamilleMaterielController;

// Route principale de l'application avec la vue d'accueil
Route::get('/', [CasierController::class, 'index'])->name('accueil');

// Routes pour afficher l'historique des emprunts et envoyer des messages SMS
Route::get('/historique', [EmpruntsController::class, 'getEmprunts'])->name('historique.index');
Route::post('/envoyer-message', [EmpruntsController::class, 'sendMessage'])->name('envoyer-message');

// Routes pour gérer les utilisateurs
Route::get('/utilisateur', [UsersController::class, 'getUtilisateurs']);
Route::put("updateUtilisateur/{id}", [UsersController::class, 'updateUtilisateur']);
Route::get("deleteUtilisateur/{id}", [UsersController::class, 'deleteUtilisateur']);
Route::post("deleteAllUtilisateur", [UsersController::class, 'deleteAllUtilisateur']);

// Routes pour gérer les adhérents
Route::get("/adherent", [AdherentController::class, 'getAdherent']);
Route::get("deleteAdherent/{id}", [AdherentController::class, 'deleteAdherent']);
Route::post("deleteAllAdherent", [AdherentController::class, 'deleteAllAdherent']);
Route::put("updateAdherent/{id}", [AdherentController::class, 'updateAdherent']);
Route::post("addAdherent", [AdherentController::class, 'addAdherent']);
Route::post("importAdherent", [AdherentController::class, 'importAdherent']);

// Routes pour afficher le tableau de bord de l'application 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour gérer le profil de l'utilisateur connecté 
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour gérer le matériel 
Route::get("/materiel", [MaterielController::class, 'getMateriel']);
Route::get('/filtrer-materiels', [MaterielController::class, 'filtrerMateriels']);
Route::post("addMateriel", [MaterielController::class, 'addMateriel']);
Route::put("updateMateriel/{id}", [MaterielController::class, 'updateMateriel']);
Route::get("deleteMateriel/{id}", [MaterielController::class, 'deleteMateriel']);
Route::post("deleteAllMateriel", [MaterielController::class, 'deleteAllMateriel']);

// Routes pour gérer les familles de matériel (CRUD)
Route::get("/familleMateriel", [FamilleMaterielController::class, 'getFamille']);
Route::post("addFamille", [FamilleMaterielController::class, 'addFamille']);
Route::post("deleteAllFamille", [FamilleMaterielController::class, 'deleteAllFamille']);
Route::put("updateFamille/{id}", [FamilleMaterielController::class, 'updateFamille']);
Route::get("deleteFamille/{id}", [FamilleMaterielController::class, 'deleteFamille']);

// Routes pour afficher les pages de confidentialité, conditions d'utilisation et de contact
Route::get('/confidentialite', function () {
    return view('confidentialite');
})->name('confidentialite');

Route::get('/conditions', function () {
    return view('conditions');
})->name('conditions');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Authentification des utilisateurs
require __DIR__.'/auth.php';
