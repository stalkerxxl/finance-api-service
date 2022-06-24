<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('earnings', function (Blueprint $table) {
            $table->unique(
                ['company_id', 'date'],
                'unique_index'
            );
        });
    }

    public function down()
    {
        Schema::table('earnings', function (Blueprint $table) {
            $table->dropIndex('unique_index');
        });
    }
};
