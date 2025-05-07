<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('security_measures', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('type');
      $table->text('description');
      $table->string('status');
      $table->json('settings')->nullable();
      $table->date('implementation_date');
      $table->date('review_date')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('security_measures');
  }
};
