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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Primary key');

            $table->foreignId('vc_id')
                ->constrained('vcs')
                ->onDelete('cascade')
                ->comment('Related VC ID');

            $table->text('subject')->comment('Email subject');
            $table->string('from_email')->comment('Sender email address');
            $table->string('to_email')->nullable()->comment('Recipient email address');

            $table->longText('body_plain')->comment('Plain text body');
            $table->longText('body_html')->nullable()->comment('HTML body content');

            $table->timestamp('sent_at')->nullable()->comment('Original email sent time');
            $table->timestamp('received_at')->comment('Time received by crawler');

            $table->unsignedBigInteger('message_id')->nullable()->comment('Email message ID header');

            $table->string('hash')->nullable()->comment('Hash for content deduplication');

            $table->enum('processing_status', ['pending', 'processing', 'processed', 'failed'])
                ->default('pending')
                ->comment('Processing state for further automation');

            $table->boolean('is_forwarded')->default(false)->comment('Whether forwarded to users');
            $table->timestamp('forwarded_at')->nullable()->comment('Time forwarded to users');

            $table->timestamps();

            // Indexes for performance & deduplication
            $table->index('message_id'); // No unique if nullable
            $table->index('hash');
            $table->index('vc_id');
            $table->index('processing_status');
            $table->index(['vc_id', 'received_at']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
