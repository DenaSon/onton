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
        Schema::create('vc_investments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('investor_id')->constrained('vcs')->onDelete('cascade');
            $table->foreignId('portfolio_id')->constrained('vcs')->onDelete('cascade');

            $table->timestamps();

            $table->unique(['investor_id', 'portfolio_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vc_investments');
    }
};
