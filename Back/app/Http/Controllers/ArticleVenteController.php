<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\ArticleVente;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

use App\Http\Resources\CategorieResource;
use App\Http\Requests\ArticleVenteRequest;

class ArticleVenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit=3;
        return ArticleVente::paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleVenteRequest $request)
    {
        $fileName = time() . '.' . $request->photo;

        if ( count($request->articlesConfection)<3) {
            return new ArticleResource([],"Le nombre d'articles de confection doit au moins être egale à 3!");
        }
        
        $articlesCollection=collect($request->articlesConfection);
        $categories= $articlesCollection->map(function($categorie){
            $article= Article::where("id", $categorie["idArticle"])->first();
            $categorie=Categorie::where("id",$article->categorie_id)->first();
            return $categorie->libelle;
        });
        // return $categories;
        if (!$categories->contains("Tissus") || !$categories->contains("files") || !$categories->contains("Bouton")) {
            return new ArticleResource(
                [],"un article de vente doit contenir au moins un tissu, un file et un bouton !");
        }
        
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
        if ($article) {
            foreach ($request->articlesConfection as $objet) {
                $idArticle = $objet["idArticle"];
                $quantite = $objet["qte_article"];
              
                $article->articles_confection()->attach(
                  [$idArticle],
                  ['quantité' => $quantite]
                );
              }
            
            return new ArticleResource($article,"article inséré avec succés !");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($article)
    {
        $article= ArticleVente::where("libelle",$article)->first();

        if ($article) {
            return new ArticleResource($article,"");
        }
        else{
            return new ArticleResource($article, "Cette categorie n'existe pas");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleVente $articlesVente)
    {
        $articlesVente->update($request->only("libelle", "photo", "prix_vente","qte_stock","categorie_id",
                                              "cout_fabrication","marge_article","promo"));
        return new ArticleResource($articlesVente,"Article modifié avec succés");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleVente $articlesVente)
    {
        if ($articlesVente) {
            $articlesVente->delete();
            return new ArticleResource($articlesVente,"Article supprimé avec succes !");
        }
        
        return new ArticleResource([],"Cet article n'existe pas !");
    }
}
