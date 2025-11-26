<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Translation;

class roles_permission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الأدوار


        if (!Role::where('name', 'super admin')->exists()) {
            $role = Role::create(['name' => 'super admin', 'guard_name' => 'web']);
        } else {
            $role = Role::where('name', 'super admin')->first();
        }

        $permissions = [


            'create user',
            'edit user',
            'delete user',
            'view users',
            'show user',


            'create role',
            'edit role',
            'delete role',
            'view roles',



            'create permission',
            'edit permission',
            'delete permission',
            'view permissions',


            'view activity logs',


            'view languages',
            'create language',
            'edit language',
            'delete language',
            'set default language',

            'view translations',
            'edit translations',
            'import translations',
            'export translations',
            'publish translations',


        ];

        foreach ($permissions as $permission) {
            if (!\Spatie\Permission\Models\Permission::where('name', $permission)->exists()) {
                $perm = \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'web']);
                $role->givePermissionTo($perm);
            }
        }


        // $user = \App\Models\User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'test@example.com',
        //     'password' => Hash::make('password'), // password
        //     'status' => 'active',
        // ]);

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'], // الشروط للبحث
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        $user->assignRole('super admin');



        $langs = [
            ['name' => 'English', 'code' => 'en', 'is_default' => true, 'direction' => 'ltr', 'is_active' => true],
            ['name' => 'Arabic', 'code' => 'ar', 'is_default' => false, 'direction' => 'rtl', 'is_active' => true],
        ];

        foreach ($langs as $lang) {
            if (!\App\Models\Language::where('code', $lang['code'])->exists()) {
                \App\Models\Language::create($lang);
            }
        }






        $arabic_translations = json_decode(file_get_contents(database_path('seeders/ar.json')), true);


        foreach ($arabic_translations as $key => $value) {
            Translation::firstOrCreate(
                ['key' => $key, 'locale' => 'ar'],
                ['value' => $value]
            );
        }
    }
}
