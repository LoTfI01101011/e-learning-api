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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->enum('field' , ['computer science' , 'mathematics' , 'english' , 'other']);
            $table->string('module');
            $table->unsignedTinyInteger('type')->default(0);
            $table->string('location')->nullable();
            $table->integer('price');
            $table->unsignedTinyInteger('status')->default(0);
            $table->smallInteger('student_count');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
