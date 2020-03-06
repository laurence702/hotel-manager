<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_voucher', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('voucher_code')->index();
            $table->integer('amount');
            $table->boolean('is_used');
            $table->unsignedInteger('used_by');
            $table->foreign('used_by')->references('id')->on('customers');
            $table->unsignedInteger('applied_by');
            $table->foreign('applied_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_voucher', function (Blueprint $table) {
            //
        });
    }
}
