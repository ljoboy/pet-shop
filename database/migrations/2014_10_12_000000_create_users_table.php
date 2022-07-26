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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid();
            $table->bigIncrements('id');
            $table->index(['id']);
            $table->dropPrimary('id');
            $table->primary(['uuid']);
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_admin')->default(false);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address');
            $table->string('phone_number');
            $table->boolean('is_marketing')->default(false);
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
