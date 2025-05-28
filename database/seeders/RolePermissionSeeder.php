<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat permissions
        $permissions = [
            // Tambahan untuk cocokkan dengan middleware
            'manage kegiatans',
            'manage donasis',
            'manage pendaftarans',
            'manage users',
            'manage pemberi_donasis', // Added middleware permission

            'kegiatan.view',
            'kegiatan.create',
            'kegiatan.edit',
            'kegiatan.delete',
            'kegiatan.register',

            'pendaftaran.view',
            'pendaftaran.approve',
            'pendaftaran.reject',

            'donasi.view',
            'donasi.create',
            'donasi.edit',
            'donasi.delete',
            'donasi.manage_pemberi',

            'pemberi_donasi.view',
            'pemberi_donasi.create',
            'pemberi_donasi.edit',
            'pemberi_donasi.delete',
            'pemberi_donasi.report',
            'pemberi_donasi.view_all', // For admins to see all donations

            'user.view',
            'user.edit',
            'user.delete',
            'user.assign_role',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions ke role
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo([
            'kegiatan.view',
            'kegiatan.register',
            'pemberi_donasi.view',    // Users can create donations
            'donasi.view',            // Users can view donation campaigns
        ]);

        // Buat akun admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('12345678'), // ganti dengan password aman
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole($admin);

        // Buat akun user biasa
        $regularUser = User::firstOrCreate(
            ['email' => 'relawan@gmail.com'],
            [
                'name' => 'Relawan Pertama',
                'password' => Hash::make('12345678'), // ganti dengan password aman
                'email_verified_at' => now(),
            ]
        );
        $regularUser->assignRole($user);
    }
}
