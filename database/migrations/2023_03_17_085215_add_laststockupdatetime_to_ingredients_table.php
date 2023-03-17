<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ingredients',function (Blueprint $table) {
            $table->dateTime('last_stock_update_date')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::table('ingredients',function (Blueprint $table) {
            $table->dropColumn('last_stock_update_date');
        });
    }
};
