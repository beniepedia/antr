<?php

namespace App\Validation;

class KaryawanMessages
{
    public static function getRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_id' => 'nullable|string|unique:profiles,employee_id',
            'position' => 'required|in:operator,supervisor,manager',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'license_number' => 'nullable|string',
            'whatsapp' => 'required|string|unique:profiles,whatsapp',
            'address' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'avatar' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public static function getMessages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'employee_id.unique' => 'ID karyawan sudah digunakan.',
            'position.required' => 'Posisi wajib dipilih.',
            'position.in' => 'Posisi tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.unique' => 'Nomor WhatsApp sudah digunakan.',
            'experience_years.integer' => 'Tahun pengalaman harus berupa angka.',
            'experience_years.min' => 'Tahun pengalaman tidak boleh negatif.',
            'avatar.image' => 'File avatar harus berupa gambar.',
            'avatar.max' => 'Ukuran avatar maksimal 2MB.',
        ];
    }
}