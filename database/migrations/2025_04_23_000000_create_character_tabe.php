<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('r_p_g_characters', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->text('description');
            $table->string('rarity');
            $table->text('abilities')->nullable();
            $table->string('image')->nullable();
            $table->integer('battles_won')->default(0);
            $table->integer('total_battles')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('r_p_g_characters');
    }
};
