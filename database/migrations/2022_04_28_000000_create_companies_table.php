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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exchange_id');
            $table->unsignedBigInteger('industry_id');
            $table->string('ticker')->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('country');
            $table->string('currency', 3);
            $table->decimal('fast_price', 8, 2)->nullable();
            $table->date('ipo_date');
            $table->string('logo')->nullable();
            $table->string('logo_api_url')->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('shares_out');
            $table->string('web_url')->nullable();
            $table->json('fin_data')->nullable();
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('companies');
    }
};
