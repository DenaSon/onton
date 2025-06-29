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
        Schema::create('vcs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Primary key');

            $table->string('name')->comment('Name of the VC firm');
            $table->string('country')->nullable()->comment('Country of registration (optional)');
            $table->string('website')->nullable()->comment('Official website');
            $table->string('substack_url')->nullable()->comment('Optional Substack URL');
            $table->string('medium_url')->nullable()->comment('Optional Medium URL');
            $table->string('blog_url')->nullable()->comment('Optional Blog URL');
            $table->json('official_x_accounts')->nullable()->comment('Array of official X (Twitter) accounts');
            $table->json('staff_x_accounts')->nullable()->comment('Array of staff X (Twitter) accounts');

            $table->string('logo_url')->nullable()->comment('Logo image URL');

            $table->boolean('is_active')->default(true)->comment('Whether the VC is currently active');
            $table->float('rating')->nullable()->comment('Optional internal rating or score');

            $table->timestamps();

            $table->index('country');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vcs');
    }
};
