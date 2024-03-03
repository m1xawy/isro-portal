<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagoptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::connection('account')->hasTable('_Rigid_MagOptDesc')) {
            Schema::connection('account')->create('_Rigid_MagOptDesc', static function (Blueprint $table) {
                $table->integer('id'); // MagParam ID
                $table->string('name');
                $table->string('desc');
                $table->integer('mLevel');
                $table->string('extension')->nullable();
                $table->integer('sortkey');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('account')->dropIfExists('_Rigid_MagOptDesc');
    }
}
