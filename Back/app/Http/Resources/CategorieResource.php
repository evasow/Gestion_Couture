<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public $message;

    public function __construct($resource, $message)
    {
        $this->resource = $resource;
        $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            'message' => $this->message,
            'data' => parent::toArray($request),
            "success" => Response::HTTP_OK,
        ];
    }
}
