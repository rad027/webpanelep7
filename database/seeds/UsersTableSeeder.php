<?php

use App\Models\Points;
use App\Models\AboutUs;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\RanUser\UserInfo4;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $profile = new Profile();
        $adminRole = Role::whereName('Admin')->first();
        $userRole = Role::whereName('User')->first();

        // Seed test admin
        $seededAdminEmail = 'admin@admin.com';
        $user = User::where('email', '=', $seededAdminEmail)->first();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'admin',
                'first_name'                     => $faker->firstName,
                'last_name'                      => $faker->lastName,
                'email'                          => $seededAdminEmail,
                'password'                       => Hash::make('password'),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_confirmation_ip_address' => $faker->ipv4,
                'admin_ip_address'               => $faker->ipv4,
            ]);

            UserInfo4::create([
                'UserName' => 'admin',
                'UserID' => 'admin',
                'UserPass' => strtoupper(substr(md5(Hash::make('password')),0,19)),
                'UserPass2' => strtoupper(substr(md5(Hash::make('1234')),0,19)),
                'UserEmail' => $seededAdminEmail,
                'UserSQ' => '1',
                'UserSA' => 'adminpogi',
                'UserAvailable' => 0,
                'ChaRemain' => 3
            ]);

            AboutUs::create([
                'user_id'       =>  '1',
                'content'       =>  'Welcome to <b>'.config('app.name').'</b>! Enjoy your visit here.',
                'updated_by'    =>  '1'
            ]);

            $user->profile()->save($profile);
            $user->attachRole($adminRole);

            $user->points()->create([
                'points'    =>  0,
                'Vpoints'   =>  0
            ]); 
            $user->save();
        }
    }
}
