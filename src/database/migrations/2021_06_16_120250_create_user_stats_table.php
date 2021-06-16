<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatsTable extends Migration
{
    public function up()
    {
        Schema::create('user_stats', function (Blueprint $table) {
            $table->date('month')->primary();
            $table->jsonb('user_by_roles')->default('{}');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_stats');
    }
}
