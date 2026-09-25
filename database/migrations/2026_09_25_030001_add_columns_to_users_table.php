<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('type')->default('customer')->after('email');
            $table->string('cpf', 14)->nullable()->unique()->after('type');
            $table->string('phone', 20)->nullable()->after('cpf');
            $table->string('avatar')->nullable()->after('phone');
            $table->dateTime('last_login_at')->nullable()->after('avatar');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->dateTime('blocked_at')->nullable()->after('last_login_ip');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'cpf',
                'phone',
                'avatar',
                'last_login_at',
                'last_login_ip',
                'blocked_at',
            ]);
        });
    }
};
