<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('categories')->insert(
            [
                [
                    'id' => 1,
                    'type' => 1,
                    'name' => 'Zakat'
                ],
                [
                    'id' => 2,
                    'type' => 1,
                    'name' => 'Infaq'
                ],
                [
                    'id' => 3,
                    'type' => 1,
                    'name' => 'Shodaqoh'
                ],
                [
                    'id' => 4,
                    'type' => 1,
                    'name' => 'Waqof'
                ],
                [
                    'id' => 5,
                    'type' => 2,
                    'name' => 'Bayar Listrik'
                ],
                [
                    'id' => 6,
                    'type' => 2,
                    'name' => 'Bayar Air'
                ],
                [
                    'id' => 7,
                    'type' => 2,
                    'name' => 'Kegiatan Islami'
                ],
                [
                    'id' => 8,
                    'type' => 2,
                    'name' => 'Perbaikan Peralatan Masjid'
                ]
            ]
        );

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description')->nullable();
            $table->integer('value');
            $table->integer('categories_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->integer('users_id')->unsigned()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
            $table->date('date');
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
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('categories');
    }
}
