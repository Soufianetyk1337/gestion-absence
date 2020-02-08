<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // Users data
        for ($i=1; $i <= 20; $i++) { 
            DB::table('users')->insert([
                'name' => 'John' . $i,
                'last_name' => 'Doe' . $i,
                'email' => 'john' . $i . '@doe.com',
                'password' => Hash::make('123456'), // secret
                'CIN' => chr(rand(65,90)).rand(1000000,900000),
                'type' => 'Admin',
                'image' => 'X3jQLjF17FRx5MBB.png',
                'remember_token' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=1; $i <= 20; $i++) { 
            DB::table('teachers')->insert([
                'name' => 'Adam ' . $i,
                'last_name' => 'Teacher ' . $i,
                'email' => 'john' . $i . '@doe.com',
                'phone' => ('0612345678'), // secret
                'CIN' => chr(rand(65,90)).rand(1000000,900000),
                'type' => 'Teacher',
                'remember_token' => Str::random(10),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=1; $i <= 20; $i++) { 
            DB::table('students')->insert([
                'first_name' => 'John ' . $i,
                'last_name' => 'Smith ' . $i,
                'email' => 'john' . $i . '@doe.com',
                'CNE' => chr(rand(65,90)).rand(1000000,900000), 
                'phone' => ('0612345678'),
                'image' => 'AMX1nweP2yPz3G5M.jpeg',
                'filliere' => rand(0, 1) ? 'GI' : 'TM',
                'annee_scolaire' => '2019 - 2020',
                'DOB' => rand(1,31).'-'.rand(1,12).'-'.rand(1990,2000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=1; $i <= 20; $i++) { 
            DB::table('modules')->insert([
                'name' => 'module ' . $i,
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for ($i=1; $i <= 20; $i++) { 
            DB::table('absences')->insert([
                'justification' => rand(0,1)? 'Non' : 'Oui',
                'hours' => rand(2,4),	
                'type' => rand(0 , 1) ? 'retard' : 'maladie',
                 'date' => (rand(1,31).'-'.rand(1,12).'-'.'2020'),
                 'module_id' => rand(1,20),
                 'student_id' => $i,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }
}
