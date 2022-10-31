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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('position_name')->nullable();
            $table->string('number_opening')->nullable();
            $table->string('salary_range_from')->nullable();
            $table->integer('salary_range_to')->nullable();
            $table->text('descripition')->nullable();
            $table->foreignId("client_id")->nullable()->constrained('clients');
            $table->string('client_name')->nullable();
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
        Schema::dropIfExists('positions');
    }
};
