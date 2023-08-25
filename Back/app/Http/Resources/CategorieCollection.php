<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategorieCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    
    
    public function __construct($collection)
    {
        $this->collection = $collection;
    }
    
    public function toArray($request)
    {
        return [
            'message' => "",
            'data' => $this->formatCat($this->collection),
            "success" => Response::HTTP_OK,
            "links" => $this->collection->toArray($request)["links"]
        ];
    }
    public function getLInks($request)
    {
        return parent::toArray($request)["links"];
    }
    private function formatCat($collection)
    {
        return $collection->map(function ($cat) {
            $idCategorie=  Categorie::where('libelle', $cat->libelle)->first()->id;
            return [
                'id' => $cat->id,
                'libelle' => $cat->libelle,
                "type" => $cat->type,
                'nbreArticle' => count(Article::where("categorie_id", $idCategorie)->get()),
            ];
        })->toArray();
    }
    

}
