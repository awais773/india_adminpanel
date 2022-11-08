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
        Schema::create('client_commercials', function (Blueprint $table) {
            $table->id();
            $table->string('form')->nullable();
            $table->string('to')->nullable();
            $table->string('percentage')->nullable();
            $table->foreignId("currency_id")->nullable()->constrained('currencies');
            $table->foreignId("client_id")->nullable()->constrained('clients');
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
        Schema::dropIfExists('client_commercials');
    }
};
