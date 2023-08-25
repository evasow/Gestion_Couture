<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleVenteController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("/categories",[CategorieController::class,"store"]);
Route::post("/categories/delete",[CategorieController::class,"destroy"]);

Route::apiResource("categories",CategorieController::class);

Route::apiResource("articles",ArticleController::class);
Route::get("/all",[ArticleController::class,"all"]);

Route::apiResource("fournisseurs",FournisseurController::class);
Route::get("categories/countArticle/{libelle}",[CategorieController::class,"countArticleToCategorie"]);

Route::apiResource("articlesVente",ArticleVenteController::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
