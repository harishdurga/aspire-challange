<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_loans', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no', 255)->unique();
            $table->unsignedBigInteger('user_id');
            $table->float('amount');
            $table->unsignedInteger('loan_term');
            $table->string('repayment_freequency', 255)->default('weekly');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
        Schema::table('term_loans', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_loans');
    }
}
