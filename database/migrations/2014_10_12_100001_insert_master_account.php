<?php

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMasterAccount extends Migration
{
    const MASTER_EMAIL = 'master@local.host';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'email'     => static::MASTER_EMAIL,
            'password'  => bcrypt('pwd12345'),
            'name'      => 'Master Account',
            'is_admin'  => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::whereEmail(static::MASTER_EMAIL)->delete();
    }
}
