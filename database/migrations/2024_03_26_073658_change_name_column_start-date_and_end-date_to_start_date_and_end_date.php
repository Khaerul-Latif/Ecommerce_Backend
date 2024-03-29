<?php

use App\Models\Promo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Promo::truncate();
        Schema::table('promo', function (Blueprint $table) {
            $table->dropColumn('start-date');
            $table->dropColumn('end-date');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
        });
    }

    public function down()
    {
        Promo::truncate();
        Schema::table('promo', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dateTime('start-date');
            $table->dateTime('end-date');
        });
    }
};
