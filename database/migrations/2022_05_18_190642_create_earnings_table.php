<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->decimal('eps_actual', 8, 4)->nullable();
            $table->decimal('eps_estimate', 8, 4)->nullable();
            $table->string('hour')->nullable();
            $table->integer('quarter')->nullable();
            $table->bigInteger('revenue_actual')->nullable();
            $table->bigInteger('revenue_estimate')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->year('year')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('earnings');
    }
};
