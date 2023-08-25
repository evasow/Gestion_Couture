<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleVente extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded=[];

    public function articles_confection()
    {
        return $this->belongsToMany(Article::class,"confection_vente");
    }
}
