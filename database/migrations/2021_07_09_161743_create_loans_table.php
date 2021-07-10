<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
             $table->id();
             $table->bigInteger('user_id')->unsigned();
             $table->float('amount',8, 2);
             $table->integer('term')->comment('number of months');
             $table->boolean('status')->default(false)->comment('0- loan not approved,1-loan approved');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('loans');
    }
}
