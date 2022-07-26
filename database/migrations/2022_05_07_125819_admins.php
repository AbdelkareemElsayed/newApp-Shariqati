<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Admins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->char('name',80);
            $table->char('email',60)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('password',60);
            $table->char('image',30);
            $table->rememberToken();
            $table->timestamps();
     
            // $table->foreignId('role_id')
            // ->constrained('adminroles')
            // ->onUpdate('cascade')
            // ->onDelete('cascade');
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

        Schema::dropIfExists('admins'); 
    }
}
