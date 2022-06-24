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
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->string('api_name');
            $table->string('email');
            $table->string('api_key');
            $table->string('base_url');
            $table->unsignedInteger('today_count')->default(0);
            $table->unsignedInteger('total_count')->default(0);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['api_name', 'email', 'api_key'], 'unique_token_for_api');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokens');
    }
};
