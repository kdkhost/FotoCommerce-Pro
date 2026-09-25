<?php
/**
 * @autor marcelo-brad rj
 * @contato Tel: 21 981325441
 * Email: contato@kdkhost.com.br
 * Telegram: @MARCELO_BRAD
 * Instagram: @marcelobradrj
 * WhatsApp: 21981325441
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Cache::forget('spatie.permission.cache');
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'albums.view',
            'albums.create',
            'albums.update',
            'albums.delete',
            'photos.view',
            'photos.create',
            'photos.update',
            'photos.delete',
            'orders.view',
            'orders.update',
            'payments.view',
            'payments.manage',
            'refunds.view',
            'refunds.create',
            'refunds.approve',
            'promotions.view',
            'promotions.create',
            'promotions.update',
            'promotions.delete',
            'customers.view',
            'customers.manage',
            'tickets.view',
            'tickets.manage',
            'settings.view',
            'settings.update',
            'seo.view',
            'seo.update',
            'storage.manage',
            'smtp.manage',
            'email_templates.manage',
            'users.manage',
            'roles.manage',
            'permissions.manage',
            'audit_logs.view',
            'visitor_logs.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $allPermissions = Permission::all();

        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        $adminAssistantPerms = Permission::whereIn('name', [
            'albums.view',
            'albums.create',
            'albums.update',
            'albums.delete',
            'photos.view',
            'photos.create',
            'photos.update',
            'photos.delete',
            'orders.view',
            'tickets.view',
            'tickets.manage',
        ])->get();

        $adminAssistant = Role::create(['name' => 'Admin Assistente', 'guard_name' => 'web']);
        $adminAssistant->permissions()->sync($adminAssistantPerms->pluck('id'));

        Role::create(['name' => 'Customer', 'guard_name' => 'web']);
    }
}
