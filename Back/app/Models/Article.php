<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function Fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class,"article_fournisseurs","article_id");
    }
    public function articles_vente()
    {
        return $this->belongsToMany(ArticleVente::class,"confection_vente");
    }
}
