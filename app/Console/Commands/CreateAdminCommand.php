<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo-commerce:create-admin 
                            {--email= : O e-mail do administrador}
                            {--password= : A senha do administrador}
                            {--name= : O nome do administrador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria ou atualiza um usuário Super Admin no sistema';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->option('name') ?: $this->ask('Nome do administrador', 'Administrador');
        $email = $this->option('email') ?: $this->ask('E-mail do administrador');

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            $this->error('E-mail inválido.');

            return self::FAILURE;
        }

        $password = $this->option('password') ?: $this->secret('Senha do administrador');

        if (empty($password) || strlen($password) < 8) {
            $this->error('A senha deve ter pelo menos 8 caracteres.');

            return self::FAILURE;
        }

        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->password = Hash::make($password);
        $user->type = 'admin';
        $user->blocked_at = null;
        $user->save();

        if (! $user->hasRole('Super Admin')) {
            $user->assignRole($superAdminRole);
        }

        $this->info("Usuário Super Admin [{$user->email}] configurado com sucesso!");

        return self::SUCCESS;
    }
}
