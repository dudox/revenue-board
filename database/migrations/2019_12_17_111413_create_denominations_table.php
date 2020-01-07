<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denominations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount')->default(0);
            $table->integer('batch_id');
            $table->string('description');
            $table->string('identifier');
            $table->integer('duration_id');
            $table->integer('progress')->default(0);
            $table->decimal('cost', 14, 2);
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
        Schema::dropIfExists('denominations');
    }
}
