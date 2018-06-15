<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert(['email' => 'AD-001','contrasena' => password_hash('AD-098-123', PASSWORD_BCRYPT),'creacion' => Carbon::now()->format('Y-m-d H:i:s'),'actualizacion' => Carbon::now()->format('Y-m-d H:i:s'),'activo' => 1,'id_rol' => '6']);

    }
}
