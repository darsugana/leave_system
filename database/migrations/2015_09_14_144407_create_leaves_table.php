<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('duration', [
                'full day',
                'half day',
            ]);
            $table->date('from');
            $table->date('to');
            $table->text('reason')->nullable();
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
            ]);

            $table->integer('leave_type_id')->unsigned();
            $table->foreign('leave_type_id')
                ->references('id')->on('leave_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::drop('leaves');
    }
}
