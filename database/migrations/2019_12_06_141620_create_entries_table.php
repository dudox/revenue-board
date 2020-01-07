<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('session_id');
            $table->integer('batch_id');
            $table->integer('denomination_id');
            $table->integer('state_id');
            $table->decimal('cost', 14, 2);
            $table->string('customer_phone');
            $table->string('customer_name');
            $table->timestamp('expires');
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
        Schema::dropIfExists('entries');
    }
}
