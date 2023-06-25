<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Member;
use App\Models\Role;
use App\Models\RoleActionMapper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create action
        $actions = [
            [ "function" => "User", "id" => "create-user" ],
            [ "function" => "User", "id" => "update-user" ],
            [ "function" => "User", "id" => "view-user" ],
            [ "function" => "User", "id" => "delete-user" ],

            [ "function" => "Member", "id" => "create-member" ],
            [ "function" => "Member", "id" => "update-member" ],
            [ "function" => "Member", "id" => "view-member" ],
            [ "function" => "Member", "id" => "delete-member" ],

            [ "function" => "Role", "id" => "create-role" ],
            [ "function" => "Role", "id" => "update-role" ],
            [ "function" => "Role", "id" => "view-role" ],
            [ "function" => "Role", "id" => "delete-role" ],

            [ "function" => "Audit Trail", "id" => "view-audit-trail" ],
        ];

        Action::insert($actions);

        // create member
        $members = [
            [
                'name'=> 'Central Bank Malaysia',
                'code'=> 'CBKMY',
                'description'=> 'Central Bank of Malaysia',
                'status'=> 'ACTIVE',
                'member_type'=> 'CBK',
                'created_by'=> '',
                'updated_by'=> '',
            ],
            [
                'name'=> 'Malayans Banking Berhad',
                'code'=> 'MBBMY',
                'description'=> 'Malayans Banking Berhad (INX-20003994)',
                'status'=> 'ACTIVE',
                'member_type'=> 'PTT',
                'created_by'=> '1',
                'updated_by'=> '1',
            ],
            [
                'name'=> 'Bank Islami Biz Sdn. Bhd',
                'code'=> 'BBIMMY',
                'description'=> 'Bank Islami Biz (INX-23403994)',
                'status'=> 'ACTIVE',
                'member_type'=> 'PTT',
                'created_by'=> '1',
                'updated_by'=> '1',
            ],
            [
                'name'=> 'RHBB Sdn. Bhd',
                'code'=> 'RHBBMY',
                'description'=> 'RHBB Islamic Banking (INX-009488399)',
                'status'=> 'ACTIVE',
                'member_type'=> 'PTT',
                'created_by'=> '1',
                'updated_by'=> '1',
            ],
            [
                'name'=> 'Kuwaitz Financing House Sdn. Bhd',
                'code'=> 'KFHMY',
                'description'=> 'Kuwaitz Financing House (INX-009488399-X)',
                'status'=> 'ACTIVE',
                'member_type'=> 'PTT',
                'created_by'=> '1',
                'updated_by'=> '1',
            ],
            [
                'name'=> 'CIMBZ Group Holding Berhad',
                'code'=> 'CIMBZMY',
                'description'=> 'CIMBZMY Group Holding (GPX-299888499)',
                'status'=> 'ACTIVE',
                'member_type'=> 'PTT',
                'created_by'=> '1',
                'updated_by'=> '1',
            ],
        ];

        Member::insert($members);

        // create role
        $roles = [
            // central bank
            [
                'name' => 'Administrator CBKMY',
                'description' => 'Administrator role for Central Bank of Malaysia',
                'member_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Operator CBKMY',
                'description' => 'Operator role for Central Bank of Malaysia',
                'member_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Analyst CBKMY',
                'description' => 'Analyst role for Central Bank of Malaysia',
                'member_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            // maybanks
            [
                'name' => 'Administrator MBBMY',
                'description' => 'Administrator role for Malayans Banking Berhad',
                'member_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Operator MBBMY',
                'description' => 'Operator role for Malayans Banking Berhad',
                'member_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'L3 Support Team MBBMY',
                'description' => 'Operator L2 for Malayans Banking Berhad',
                'member_id' => 2,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            // bank islam
            [
                'name' => 'Administrator BBIMMY',
                'description' => 'Administrator role for Bank Islami Berhad',
                'member_id' => 3,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Operator BBIMMY',
                'description' => 'Operator role for Bank Islami Berhad',
                'member_id' => 3,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Management Role BBIMMY',
                'description' => 'Management role for Bank Islami Berhad',
                'member_id' => 3,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        Role::insert($roles);

        $role_actions_mapper = [
            /**
             * Central Bank
             */
            [ 'role_id' => 1, 'action_id' => 'create-user'],
            [ 'role_id' => 1, 'action_id' => 'update-user'],
            [ 'role_id' => 1, 'action_id' => 'view-user'],
            [ 'role_id' => 1, 'action_id' => 'delete-user'],

            [ 'role_id' => 1, 'action_id' => 'create-member'],
            [ 'role_id' => 1, 'action_id' => 'update-member'],
            [ 'role_id' => 1, 'action_id' => 'view-member'],
            [ 'role_id' => 1, 'action_id' => 'delete-member'],

            [ 'role_id' => 1, 'action_id' => 'create-role'],
            [ 'role_id' => 1, 'action_id' => 'update-role'],
            [ 'role_id' => 1, 'action_id' => 'view-role'],
            [ 'role_id' => 1, 'action_id' => 'delete-role'],

            [ 'role_id' => 1, 'action_id' => 'view-audit-trail'],

            // operator - central bank
            [ 'role_id' => 2, 'action_id' => 'create-user'],
            [ 'role_id' => 2, 'action_id' => 'update-user'],
            [ 'role_id' => 2, 'action_id' => 'view-user'],
            [ 'role_id' => 2, 'action_id' => 'delete-user'],

            [ 'role_id' => 2, 'action_id' => 'create-member'],
            [ 'role_id' => 2, 'action_id' => 'update-member'],
            [ 'role_id' => 2, 'action_id' => 'view-member'],
            [ 'role_id' => 2, 'action_id' => 'delete-member'],

            [ 'role_id' => 2, 'action_id' => 'view-audit-trail'],

            // analyst - view
            [ 'role_id' => 3, 'action_id' => 'view-user'],

            [ 'role_id' => 3, 'action_id' => 'view-member'],

            [ 'role_id' => 3, 'action_id' => 'view-audit-trail'],

            [ 'role_id' => 3, 'action_id' => 'view-role'],


            /**
             *  Maysbank
             */
            [ 'role_id' => 4, 'action_id' => 'create-user'],
            [ 'role_id' => 4, 'action_id' => 'update-user'],
            [ 'role_id' => 4, 'action_id' => 'view-user'],
            [ 'role_id' => 4, 'action_id' => 'delete-user'],

            [ 'role_id' => 4, 'action_id' => 'create-role'],
            [ 'role_id' => 4, 'action_id' => 'update-role'],
            [ 'role_id' => 4, 'action_id' => 'view-role'],
            [ 'role_id' => 4, 'action_id' => 'delete-role'],

            [ 'role_id' => 4, 'action_id' => 'view-audit-trail'],

            // operator - central bank
            [ 'role_id' => 5, 'action_id' => 'create-user'],
            [ 'role_id' => 5, 'action_id' => 'update-user'],
            [ 'role_id' => 5, 'action_id' => 'view-user'],
            [ 'role_id' => 5, 'action_id' => 'delete-user'],

            [ 'role_id' => 5, 'action_id' => 'view-audit-trail'],

            // analyst - view
            [ 'role_id' => 6, 'action_id' => 'view-user'],

            [ 'role_id' => 6, 'action_id' => 'view-audit-trail'],

            [ 'role_id' => 6, 'action_id' => 'view-role'],
        ];

        RoleActionMapper::insert($role_actions_mapper);

        // create user
        $users = [
            [
                'member_id' => 1,
                'role_id' => 1,
                'username' => 'cbkadmin',
                'name' => 'CBK Admin',
                'email' => 'engkunazri0609@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'member_id' => 1,
                'role_id' => 2,
                'username' => 'cbkoperator',
                'name' => 'CBK Operator',
                'email' => 'engkunazri0609@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'member_id' => 1,
                'role_id' => 3,
                'username' => 'cbkanalyst',
                'name' => 'CBK Analyst',
                'email' => 'engkunazri0609@gmail.com',
                'password' => Hash::make('password')
            ],
            // maybanks
            [
                'member_id' => 2,
                'role_id' => 4,
                'username' => 'mbbmyadmin',
                'name' => 'Maysbank Admin',
                'email' => 'engkunazri0609@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'member_id' => 2,
                'role_id' => 5,
                'username' => 'mbbmyopr',
                'name' => 'Maysbank Opr',
                'email' => 'engkunazri0609@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'member_id' => 2,
                'role_id' => 6,
                'username' => 'mbbmyl3',
                'name' => 'Maybanks L3',
                'email' => 'engkunazri0609@gmail.com',
                'password' => Hash::make('password')
            ],
        ];

        User::insert($users);
    }
}
