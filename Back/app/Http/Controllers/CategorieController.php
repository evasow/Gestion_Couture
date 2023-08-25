<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Http\Resources\CategorieCollection;
use App\Http\Resources\CategorieResource;
use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function countArticleToCategorie($libelle){
      $idCategorie=  Categorie::where('libelle', $libelle)->first()->id;

      return count(Article::where("categorie_id", $idCategorie)->get());
    }

    public function index(Request $request)
    {
        $limit=3;
        return new CategorieCollection(Categorie::paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request)
    {
        $categorie= Categorie::firstOrCreate([
            "libelle" =>$request->libelle,
            "type" =>$request->type
        ]);
        
        return (new CategorieResource($categorie, 'Categorie inséré avec succés'))->toArray($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($category, Request $request)
    {
       $categorie= Categorie::where("libelle",$category)->first();
       if ($categorie) {
            return (new CategorieResource($categorie,""))->toArray($request);
       }
       else{
            return (new CategorieResource($categorie, "Cette categorie n'existe pas"))->toArray($request);
       }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request, Categorie $category)
    {
        $category->libelle = $request->libelle;
        $category->save();

        return (new CategorieResource($category, "Categorie modifié avec succés"))->toArray($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , Categorie $category)
    {
        $categories = Categorie::find($request->ids);
        if (count($categories)!=0) {
            
            $categories->each->delete();
            return (new CategorieResource($categories, "suppression fait avec succés !"))->toArray($request);

        }
        else{
            return (new CategorieResource($categories, "suppression Impossible !"))->toArray($request);

        }

    }
}
