<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xe', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ten');
            $table->string('ten_hien_thi');
            $table->string('ten_url');
            $table->string('anh')->default('default.png');
            $table->text('gioi_thieu')->nullable();
            $table->integer('gia');
            $table->tinyInteger('trang_thai')->default(config('car.status.available'));
            $table->integer('danh_muc_id');
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
        Schema::dropIfExists('xe');
    }
}
