<?php

/**
 * Description of UserTableSeeder
 *
 * @author Jozef
 */
class UserTableSeeder extends Seeder {

    public function run() {
        DB::table('users')->delete();
        User::create(array(
            'name' => 'Jozef',
            'surname' => 'Dúc',
            'email' => 'jozef.d13@gmail.com',
            'password' => Hash::make('123456'),
            'confirmed' => 1,
            'admin' => 1,
            'teacher' => 1,
        ));
        User::create(array(
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'confirmed' => 1,
            'admin' => 1,
            'teacher' => 1,
        ));
    }

}
