<?php

namespace App\Http\Controllers;

use App\Models\ArticleVente;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;

class ArticleVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fileName = time() . '.' . $request->photo;

        $article= ArticleVente::firstOrCreate([
            "libelle" => $request->libelle,
            "photo" => $fileName,
            "categorie_id" => $request->categorie_id,
            "promo" => $request->promo,
            "ref" => $request->ref,
            "prix_vente" => $request->prix_vente,
            "cout_fabrication" => $request->cout_fabrication,
            "marge_article" => $request->marge_article,
            "qte_stock" => $request->qte_stock,
        ]);
        $article->articles_confection()->attach($request->idsArticlesConfection);
    
        return new ArticleResource($article,"article inséré avec succés !");
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleVente $articleVente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleVente $articleVente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleVente $articleVente)
    {
        //
    }
}
