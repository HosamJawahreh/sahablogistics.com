<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

#[Signature('sahab:create-admin')]
#[Description('Create or update the Filament admin user from ADMIN_* environment variables.')]
class CreateAdminUser extends Command
{
    public function handle(): int
    {
        $name = (string) env('ADMIN_NAME', 'Sahab Admin');
        $email = (string) env('ADMIN_EMAIL');
        $password = (string) env('ADMIN_PASSWORD');

        $validator = Validator::make(
            compact('name', 'email', 'password'),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:12'],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            $this->comment('Set ADMIN_NAME, ADMIN_EMAIL and a strong ADMIN_PASSWORD in .env, then re-run php artisan sahab:create-admin.');

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'is_admin' => true,
            ],
        );

        $this->info("Admin user ready: {$user->email}");

        return self::SUCCESS;
    }
}
