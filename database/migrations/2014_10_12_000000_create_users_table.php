<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('roles')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Admin'
                ],
                [
                    'id' => 2,
                    'name' => 'Pengurus'
                ]
            ]
        );

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('roles_id')->unsigned()->default(2);
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'name' => 'Aldi',
                'email' => 'aldi.45ckr@gmail.com',
                'password' => bcrypt('123456'),
                'roles_id' => 1
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
}
