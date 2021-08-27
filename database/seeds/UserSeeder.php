<?php

use App\Model\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Anônimo',
            'email' => 'anonimo@uffs.edu.br',
            'password' => 'dd',
            'username' => 'anonimo',
            'uid' => 'anonimo',
            'cpf' => '000',
            'type' => User::NORMAL
        ]);

        User::create([
            'name' => 'Fernando Bevilacqua',
            'email' => 'fernando.bevilacqua@uffs.edu.br',
            'password' => 'dd',
            'username' => 'fernando.bevilacqua',
            'uid' => 'fernando.bevilacqua',
            'cpf' => '000',
            'type' => User::ADMIN
        ]);        
    }
}
