<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Member::truncate();

        Member::insert([
            [
                'name' => 'Maybank Malaysia Sdn. Bhd',
                'code' => 'MBB',
                'description' => 'Maybank Description',
                'status' => 'ACTIVE',
                'member_type' => 'PTT',
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ]);

        User::insert([
            [
                'member_id' => 1,
                'username' => 'username',
                'name' => 'Testing User 1',
                'email' => 'testinguserone@example.com.my',
                'password' => Hash::make('password'),
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
