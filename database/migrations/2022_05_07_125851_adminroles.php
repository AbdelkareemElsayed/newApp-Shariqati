<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Adminroles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('adminroles', function (Blueprint $table) {
            $table->id();
            $table->char('title_ar', 50);
            $table->char('title_en', 50);
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
        // 
        Schema::dropIfExists('adminroles');
    }
}
