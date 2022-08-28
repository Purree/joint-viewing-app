<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('current_room_id')->nullable()->nullable();
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();
            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();
            $table->string('secret');
            $table->string('avatar', 2048)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('current_room_id')
                ->references('id')
                ->on('rooms')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
