<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TableSeeder');
	}
}

class TableSeeder extends seeder {

	public function run() {
		DB::table('users')->delete();
		DB::table('usershistory')->delete();
		DB::table('cuisines')->delete();
		DB::table('documents')->delete();
		DB::table('emailenquiries')->delete();
		DB::table('emails')->delete();
		DB::table('enquiries')->delete();
		DB::table('leads')->delete();
		DB::table('menudocuments')->delete();
		DB::table('menuitems')->delete();
		DB::table('menuitemshistory')->delete();
		DB::table('menus')->delete();
		DB::table('menushistory')->delete();
		DB::table('preferences')->delete();
		DB::table('profiles')->delete();
		DB::table('profileshistory')->delete();
		DB::table('reviews')->delete();
		DB::table('amendments')->delete();

		$password = Hash::make('test123');

		$user = User::create(array('password' => $password, 'type' => 'admin', 'active' => 1, 'confirmed' => 1, 'email' => 'vincentsylo@gmail.com'));
		$user->createdby = $user->id;
		$user->save();

		$userhistory = UserHistory::create(array('userid' => $user->id, 'firstname' => 'System', 'lastname' => 'Admin', 'updatedby' => $user->id));
		$userhistory->updatedby = $user->id;
		$userhistory->save();

		Cuisine::firstOrCreate(array('name' => 'Australian', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'African', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'American', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'BBQ', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Breakfast & Brunch', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Caribbean', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Chinese', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'French', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'German', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Indian', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Italian', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Japanese', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Korean', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Mexican', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Spanish', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Middle Eastern', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Vietnamese', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Thai', 'active' => '1'));
		Cuisine::firstOrCreate(array('name' => 'Brazilian', 'active' => '1'));

		Preference::firstOrCreate(array('id' => '1', 'adminemail' => 'vincentsylodev@gmail.com'));
	}
}
