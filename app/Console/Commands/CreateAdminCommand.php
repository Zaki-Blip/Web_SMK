<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Membuat atau memperbarui akun admin dashboard.
 * Kata sandi dibaca dari opsi perintah atau variabel lingkungan ADMIN_PASSWORD, bukan hardcode.
 */
class CreateAdminCommand extends Command
{
    protected $signature = 'app:create-admin
                            {--name= : Nama admin}
                            {--email= : Email admin}
                            {--password= : Kata sandi admin (opsional, bisa dari ADMIN_PASSWORD)}';

    protected $description = 'Membuat atau memperbarui akun admin untuk dashboard';

    public function handle(): int
    {
        $name = (string) ($this->option('name') ?: $this->ask('Nama admin', 'Administrator'));
        $email = (string) ($this->option('email') ?: $this->ask('Email admin'));

        $password = $this->resolvePassword();

        if ($password === null) {
            return self::FAILURE;
        }

        $validator = Validator::make(
            ['name' => $name, 'email' => $email, 'password' => $password],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ],
            [
                'name.required' => 'Nama admin wajib diisi.',
                'email.required' => 'Email admin wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Kata sandi wajib diisi.',
                'password.min' => 'Kata sandi minimal 8 karakter.',
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => User::ROLE_ADMIN,
            ],
        );

        $this->info('Akun admin siap: '.$user->email.' ('.$user->name.')');
        $this->line('Silakan login di /admin/login.');

        return self::SUCCESS;
    }

    /**
     * Ambil kata sandi dari opsi --password, env ADMIN_PASSWORD, atau input interaktif.
     */
    private function resolvePassword(): ?string
    {
        $password = (string) ($this->option('password') ?: env('ADMIN_PASSWORD', ''));

        if ($password !== '') {
            return $password;
        }

        $input = (string) $this->secret('Kata sandi admin (minimal 8 karakter)');
        $confirmation = (string) $this->secret('Ulangi kata sandi admin');

        if ($input !== $confirmation) {
            $this->error('Kata sandi dan ulangannya tidak sama.');

            return null;
        }

        return $input;
    }
}
