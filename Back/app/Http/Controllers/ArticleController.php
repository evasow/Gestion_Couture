<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\AllCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Models\Fournisseur;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit=3;
        return new ArticleCollection(Article::paginate($limit),"");
    }
    public function all()
    {
       $categories=Categorie::where("type","Confection")->get();
       $fournisseurs=Fournisseur::all();
       return new AllCollection($categories,$fournisseurs);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        $fileName = time() . '.' . $request->photo;
        // $request->photo->storeAs('public/images', $fileName);
        
       $article= Article::firstOrCreate([
            "libelle" => $request->libelle,
            "photo" => $fileName,
            "categorie_id" => $request->categorie_id,
            "ref"=> $request->ref,
            "prix" => $request->prix,
            "qte_stock" => $request->qte_stock
        ]);
        $article->fournisseurs()->attach($request->fournisseursIds);
    
        return new ArticleResource($article,"article inséré avec succés !");
    }
    /**
     * Display the specified resource.
     */
    public function show($article, Request $request)
    {
        $article= Article::where("libelle",$article)->first();

       if ($article) {
            return (new ArticleResource($article,""))->toArray($request);
       }
       else{
            return (new ArticleResource([],"Cet article n'existe pas !"))->toArray($request);
       }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->only("libelle", "photo", "prix", "qte_stock","categorie_id"));
        return new ArticleResource($article,"Article modifié avec succés");
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article) {
            $article->delete();
            return new ArticleResource($article,"Article supprimé avec succes !");
        }
        
        return new ArticleResource([],"Cet article n'existe pas !");
    }
}
