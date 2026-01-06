<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Status;
use App\Models\StatusDetail;
use App\Models\Food;
use App\Models\Cart;
use App\Models\User;


class StatusController extends Controller
{
    public function index()
    {
        // status dengan user yang sudah login
        $statuses = Status::where('user_id', auth()->id())->with('statusDetails.food')->get();
        return view('status.index', compact('statuses'));
    }
    public function edit($statusId)
    {
        $status = Status::findOrFail($statusId);
        // cek apakah status milik user yang sedang login
        if ($status->user_id !== auth()->id()) {
            return redirect()->route('status.index')->with('error', 'Anda tidak memiliki akses untuk mengedit status ini');
        }
        return view('status.edit', compact('status'));
    }

    public function update($statusId)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'Nomor' => 'required|string|max:20',
            'Alamat' => 'required|string|max:500',
        ]);
        // cek apakah status milik user yang sedang login
        $status = Status::findOrFail($statusId);
        if ($status->user_id !== auth()->id()) {
            return redirect()->route('status.index')->with('error', 'Anda tidak memiliki akses untuk mengedit status ini');
        }
        $status->name = request('name');
        $status->Nomor = request('Nomor');
        $status->Alamat = request('Alamat');
        $status->save();
        return redirect()->route('status.index')->with('success', 'Status berhasil diperbarui');
    }

    
}
