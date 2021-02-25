<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\Models\User;
        $administrator->username = "admin";
        $administrator->name = "mas admin";
        $administrator->email = "adminlarashop@gmail.com";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("larashop");
        $administrator->avatar = "sepi.png";
        $administrator->address = "jakal kaliurang";
        $administrator->save();

        $this->command->info("Seder larashop verhasil dibuat");
    }
}
