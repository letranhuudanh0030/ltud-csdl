<?php

use App\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->bigInteger('customer_id')->unsigned();
            $table->datetime('time_start', 0);
            $table->datetime('time_end', 0);
            $table->text('summary')->nullable();
            $table->text('result')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });

        factory(Event::class, 10)->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
