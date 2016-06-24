<?php

use Consensus\Entities\User;
use Consensus\Entities\UserProfile;
use Consensus\Entities\UserRole;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'username' => 'admin',
            'password' => 'admin',
            'active' => 1,
            'admin' => 1
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Admin',
            'apellidos' => 'Consensus',
            'email' => 'admin@consensus.com',
            'user_id' => '1'
        ]);

        factory(UserRole::class)->create([
            'user_id' => 1,
            'create' => 1,
            'update' => 1,
            'delete' => 1,
            'printer' => 1
        ]);

        /*
         * ABOGADO 1
         */
        factory(User::class)->create([
            'username' => 'abogado1',
            'password' => 'abogado',
            'active' => 1,
            'admin' => 0,
            'abogado_id' => 12,
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Abogado 1',
            'apellidos' => 'Consensus',
            'email' => 'abogado1@consensus.com',
            'user_id' => '2'
        ]);

        factory(UserRole::class)->create([
            'user_id' => 2,
            'create' => 1,
            'update' => 0,
            'delete' => 0,
            'printer' => 0
        ]);

        /*
         * ABOGADO 2
         */
        factory(User::class)->create([
            'username' => 'abogado2',
            'password' => 'abogado',
            'active' => 1,
            'admin' => 0,
            'abogado_id' => 15,
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Abogado 2',
            'apellidos' => 'Consensus',
            'email' => 'abogado2@consensus.com',
            'user_id' => '3'
        ]);

        factory(UserRole::class)->create([
            'user_id' => 3,
            'create' => 1,
            'update' => 1,
            'delete' => 0,
            'printer' => 0
        ]);

        /*
         * ABOGADO 3
         */
        factory(User::class)->create([
            'username' => 'abogado3',
            'password' => 'abogado',
            'active' => 1,
            'admin' => 0,
            'abogado_id' => 20,
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Abogado 3',
            'apellidos' => 'Consensus',
            'email' => 'abogado3@consensus.com',
            'user_id' => '4'
        ]);

        factory(UserRole::class)->create([
            'user_id' => 4,
            'create' => 0,
            'update' => 1,
            'delete' => 0,
            'printer' => 0
        ]);

        /*
         * CLIENTE
         */
        factory(User::class)->create([
            'username' => 'cliente',
            'password' => 'cliente',
            'active' => 1,
            'admin' => 0,
            'cliente_id' => 5,
        ]);

        factory(UserProfile::class)->create([
            'nombre' => 'Cliente',
            'apellidos' => 'Consensus',
            'email' => 'cliente@consensus.com',
            'user_id' => '5'
        ]);

    }
}
