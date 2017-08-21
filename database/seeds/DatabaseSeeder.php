<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(IgrejaTableSeeder::class);
    	$this->call(UsersTableSeeder::class);//Remover / Modificar
    	$this->call(CelulaTableSeeder::class);
    	$this->call(PerfilsTableSeeder::class);
    	$this->call(PermissaosTableSeeder::class);
    	$this->call(EventosTableSeeder::class);
    }
}
