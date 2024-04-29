<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantiteColumnToDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->integer('quantite')->default(0);
        });
    }

    public function down()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->dropColumn('quantite');
        });
    }
}
