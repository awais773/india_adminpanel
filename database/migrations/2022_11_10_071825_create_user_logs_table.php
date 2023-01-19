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
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->string('module')->nullable();
            $table->string('action')->nullable();
            $table->foreignId("user_id")->nullable()->constrained('users');
            $table->foreignId("resume_id")->nullable()->constrained('resumes');
            $table->foreignId("currency_id")->nullable()->constrained('currencies');
            $table->foreignId("status_id")->nullable()->constrained('statuses');
            $table->foreignId("position_id")->nullable()->constrained('positions');
            $table->foreignId("role_id")->nullable()->constrained('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
};
