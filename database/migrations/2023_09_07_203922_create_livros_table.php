<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string("nomeLivro");
            $table->string("volume");
            $table->string("editora");
            $table->string("edicao");
            $table->string("autor");
            $table->integer("tombo");
            $table->integer("classificacaoLivro");
            $table->date("chegada");
            $table->date("lancamento");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
