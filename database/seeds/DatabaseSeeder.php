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
        $this->call('UserTableSeeder');
        $this->call('AjustesTableSeeder');
        $this->call('ConfiguracionTableSeeder');
        $this->call('DataTableSeeder');
        $this->call('AbogadoTableSeeder');
        $this->call('ClienteTableSeeder');
        $this->call('ClienteContactoTableSeeder');
        $this->call('ExpedienteTableSeeder');
        $this->call('IntervinienteTableSeeder');
        $this->call('TareasTableSeeder');
        $this->call('CajaTableSeeder');
    }
}
