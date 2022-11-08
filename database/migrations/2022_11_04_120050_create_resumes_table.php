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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->string('sr_no')->nullable();
            $table->string('country')->nullable();
            $table->string('client')->nullable();
            $table->string('requirement')->nullable();
            $table->string('cv_shared_date')->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email_id')->nullable();
            $table->string('current_location')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('current_organisation')->nullable();
            $table->string('current_designation')->nullable();
            $table->string('exp_in_yrs')->nullable();
            $table->string('current_ctc')->nullable();
            $table->string('variable')->nullable();
            $table->string('expected_ctc')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('feedback')->nullable();
            $table->string('candidate_status')->nullable();
            $table->foreignId("status_id")->nullable()->constrained('statuses');
            $table->foreignId("user_id")->nullable()->constrained('user_id');
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
        Schema::dropIfExists('resumes');
    }
};
