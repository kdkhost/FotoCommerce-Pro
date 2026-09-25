<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('subject');
            $table->longText('body_html');
            $table->text('body_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('variables_json')->nullable();
            $table->string('language')->default('pt_BR');
            $table->foreignId('last_edited_by_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['slug']);
            $table->index(['is_active']);
            $table->index(['language']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
