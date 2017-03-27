<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['Awaiting Payment', 'Payment Received', 'Payment Updated', 'Completed', 'Failed', 'Expired', 'Cancelled', 'Refunded', 'Refunded(Partially)']);
            $table->enum('order_status', ['Processing', 'Pending', 'Cancelled', 'Completed']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
