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
            $table->string('country')->comment('Country of registration');
            $table->string('website')->comment('Official website');
            $table->text('description')->nullable()->comment('General description or introduction');
            $table->string('logo_url')->nullable()->comment('Logo image URL');

            $table->unsignedBigInteger('ticket_min')->nullable()->comment('Minimum investment ticket size (USD)');
            $table->unsignedBigInteger('ticket_max')->nullable()->comment('Maximum investment ticket size (USD)');

            $table->boolean('is_active')->default(true)->comment('Whether the VC is currently active');
            $table->float('rating')->nullable()->comment('Optional internal rating or score');

            $table->timestamps();

            $table->index('country');
            $table->index(['ticket_min', 'ticket_max']);
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
