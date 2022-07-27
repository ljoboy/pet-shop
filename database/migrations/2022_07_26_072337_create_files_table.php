<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
           $table->uuid();
           $table->bigIncrements('id');
           $table->index(['id']);
           $table->dropPrimary('id');
           $table->primary(['uuid']);
           $table->string('name');
           $table->string('path');
           $table->string('type')->comment('mime/type');
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};