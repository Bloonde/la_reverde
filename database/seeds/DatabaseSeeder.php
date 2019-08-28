<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\RegisterUser;
use App\User;

class DatabaseSeeder extends Seeder {

    public function run() {
        Model::unguard();
        

        for ($i = 0; $i < 5; $i++) {
            RegisterUser::create([
                'name' => 'Usuario'.$i,
                'surname' => 'Apellidos'.$i,
                'address' => 'Dirección'.$i,
                'city' => 'Ciudad'.$i,
                'cp' => 4141,
                'telephone' => '99955544'.$i,
                'email' => 'email@gmail.com'
            ]);
        }
        
        // Solo queremos un único usuario en la tabla, así que truncamos primero la tabla
        // Para luego rellenarla con los registros.
        User::truncate();

        // LLamamos al seeder de Users.
        $this->call('UserSeeder');
    }

}
