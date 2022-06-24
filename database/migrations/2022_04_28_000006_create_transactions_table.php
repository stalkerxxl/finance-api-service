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
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('insider_id');
            $table->unsignedBigInteger('share');
            $table->bigInteger('change');
            $table->date('filling_date');
            $table->date('transaction_date');
            $table->string('transaction_code');
            $table->decimal('transaction_price', 8, 4);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique([
                'company_id', 'insider_id', 'share', 'change', 'filling_date', 'transaction_date', 'transaction_code',
                'transaction_price'
            ], 'full_unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('full_unique_index');
        });
        Schema::dropIfExists('transactions');
    }
};
