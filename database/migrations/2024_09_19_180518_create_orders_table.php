<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('delivery_boy_id')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->enum('status', ['pending', 'assigned', 'delivered'])->default('pending');
            $table->timestamps();
            $table->foreign('delivery_boy_id')->references('id')->on('delivery_boys');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
