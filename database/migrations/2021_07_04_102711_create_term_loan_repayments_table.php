<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermLoanRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no', 255)->unique();
            $table->float('amount');
            $table->unsignedBigInteger('term_loan_id');
            $table->timestamps();
        });
        Schema::table('term_loan_repayments', function (Blueprint $table) {
            $table->foreign('term_loan_id')->references('id')->on('term_loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_loan_repayments');
    }
}
