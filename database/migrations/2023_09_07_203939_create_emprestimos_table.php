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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            $table->string("nomeDoLivro");
            $table->string("autorDoLivro");
            $table->integer("tomboDoLivro");
            $table->integer("idDoLivro");
            $table->string("nomeDoAluno");
            $table->integer("serieDoAluno");
            $table->string("turmaDoAluno");
            $table->integer("idDoAluno");
            $table->date("dataDeEntrega");
            $table->boolean("inProgress");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
