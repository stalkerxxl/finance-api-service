<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unique();
            $table->unsignedDecimal('current_price', 8, 4);
            $table->decimal('change_day', 8, 4);
            $table->decimal('change_percent', 8, 4);
            $table->unsignedDecimal('high_day', 8, 4);
            $table->unsignedDecimal('low_day', 8, 4);
            $table->unsignedDecimal('open_day', 8, 4);
            $table->unsignedDecimal('previous_close', 8, 4);
            $table->timestamp('quote_time');

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
        Schema::dropIfExists('quotes');
    }
};
