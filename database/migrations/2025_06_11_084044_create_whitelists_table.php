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
        Schema::create('whitelists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vc_id')
                ->constrained('vcs')
                ->onDelete('cascade')
                ->comment('Related VC');

            $table->string('email', 200)->nullable()->comment('Whitelisted email address');
            $table->string('domain', 180)->nullable()->comment('Whitelisted domain');
            $table->string('note', 250)->nullable()->comment('Optional note for internal use');

            $table->timestamps();

            // Indexing for performance
            $table->index('email');
            $table->index('domain');
            $table->index('vc_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whitelists');
    }
};
