<?php


use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{

	public function run()
	{
	    $faker = Faker\Factory::create();
	  DB::table('users')->delete();

        User::create(array(
            'name'     => 'admin',
            'thumbnail' => $faker->imageUrl(),
            'email'    => 'admin@admin.com',
            'password' => Hash::make('secret'),
            'role'=>'admin'
        ));
        User::create(array(
            'name'     => 'user',
            'thumbnail' => $faker->imageUrl(),
            'email'    => 'user@user.com',
            'password' => Hash::make('secret')
        ));
	  User::create(array(
          'name'     =>  $faker->firstName,
          'thumbnail' => $faker->imageUrl(),
	      'email'    => 'chris@inmersys.com',
	      'role'    => 'admin',
	      'password' => Hash::make('awesome')
	  ));

	  User::create(array(
	      'name'     => 'Mark Name',
          'thumbnail' => $faker->imageUrl(),
	      'email'    => 'marco.perez@inmersys.com',
	      'password' => Hash::make('crackers')
	  ));


	}

}
