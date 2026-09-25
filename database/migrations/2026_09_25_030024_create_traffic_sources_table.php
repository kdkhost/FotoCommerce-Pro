<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traffic_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_session_id')->nullable()->constrained('visitor_sessions')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->string('source_classification')->nullable();
            $table->tinyInteger('match_score')->nullable();
            $table->timestamps();

            $table->index(['visitor_session_id']);
            $table->index(['order_id']);
            $table->index(['source_classification']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traffic_sources');
    }
};
