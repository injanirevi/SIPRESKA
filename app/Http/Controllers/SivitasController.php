<?php

namespace App\Http\Controllers;

use App\Models\Sivitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SivitasController extends Controller
{
    public function edit(Request $request): View
    {
        return view('sivitas.edit', [
            'sivitas' => $request->user()->sivitas,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'nim_nip' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'nim_nip')->ignore($user->id),
            ],
            'program_studi' => ['required', 'string', 'max:255'],
            'fakultas' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($user, $data) {
            $user->update(['nim_nip' => $data['nim_nip']]);

            unset($data['nim_nip']);
            $data['nama'] = $user->sivitas?->nama ?: $user->nim_nip;
            $data['jenis_sivitas'] = $user->role;
            $data['status'] = 'aktif';

            Sivitas::updateOrCreate(
                ['user_id' => $user->id],
                $data
            );
        });

        return back()->with('success', 'Profil berhasil disimpan.');
    }
}
