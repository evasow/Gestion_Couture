<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
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
            'data' => $this->formatArticles($this->collection),
            "success" => Response::HTTP_OK,
            "links" => $this->collection->toArray($request)["links"]
        ];
    }
    private function formatArticles($collection)
    {
        return $collection->map(function ($article) {
            return [
                'id' => $article->id,
                'libelle' => $article->libelle,
                'photo' => $article->photo,
                'ref' => $article->ref,
                'prix' => $article->prix,
                'qte_stock' => $article->qte_stock,
                'categorie'=> $article->categorie->libelle,
            ];
        })->toArray();
    }
}
