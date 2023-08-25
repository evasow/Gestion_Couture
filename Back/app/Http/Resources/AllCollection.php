<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public $categories;
    public $fournisseurs;
    public function __construct($categories, $fournisseurs)
    {
        $this->fournisseurs = $fournisseurs;
        $this->categories = $categories;
    }
    public function toArray($request)
    {
        return [
            'message' => "",
            'data' => $this->formatAll(),
            "success" => Response::HTTP_OK,
        ];
    }
    public function formatAll(){
        return [
            "Categories" => $this->categories,
            "fournisseurs" =>$this->fournisseurs,
        ];
    }
}
