<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('security_incidents', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->string('severity')->default('low');
      $table->string('status')->default('open');
      $table->foreignId('cloud_service_id')->nullable()->constrained()->onDelete('set null');
      $table->timestamp('detected_at');
      $table->timestamp('resolved_at')->nullable();
      $table->json('affected_resources')->nullable();
      $table->json('resolution_steps')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('security_incidents');
  }
};
