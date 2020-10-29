<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Storage;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->truncate();
        DB::table('items')->truncate();
        DB::table('categories')->truncate();

        Storage::delete(Storage::files('public/images/item_images'));

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@szerveroldali.hu',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);

        User::factory(1)->create();
        Item::factory(6)->create();
        Category::factory(8)->create();
    }
}
