<?php

use App\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone', 20)->nullable();
            $table->string('email', 50)->unique();
            $table->string('company', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->dateTime('start_event')->nullable();
            $table->text('note')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });


        factory(Customer::class, 20)->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
