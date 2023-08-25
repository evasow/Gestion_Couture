<?php

use App\Models\Categorie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_ventes', function (Blueprint $table) {
            $table->id();
            $table->string("libelle");
            $table->string("photo");
            $table->string("ref");
            $table->float("Cout de fabrication");
            $table->float("marge_article");
            $table->float("prix de vente");
            $table->string("promo")->nullable();
            $table->float("qte_stock");
            $table->date("deleted_at")->nullable();
            $table->foreignIdFor(Categorie::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_ventes');
    }
};
