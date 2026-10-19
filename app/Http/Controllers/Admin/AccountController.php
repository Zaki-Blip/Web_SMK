<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAccountRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AccountController extends Controller
{
    /**
     * Form data akun dan ganti kata sandi sendiri.
     */
    public function edit(): View
    {
        return view('admin.account.edit', [
            'user' => request()->user(),
        ]);
    }

    /**
     * Simpan perubahan nama/email dan (opsional) kata sandi baru.
     */
    public function update(UpdateAccountRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ];

        // Kata sandi hanya diganti bila kolomnya diisi; hash ditangani cast `hashed`.
        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        $user->update($data);

        return redirect()->route('admin.account.edit')->with('success', 'Data akun berhasil diperbarui.');
    }
}
