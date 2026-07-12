<?php

namespace App\Http\Controllers;

use App\Models\Due;
use App\Models\Member;
use Illuminate\Http\Request;

class DueController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekapitulasi Iuran';
        $month_year = $request->input('month_year', now()->format('Y-m'));
        
        $members = Member::with(['dues' => function ($query) use ($month_year) {
            $query->where('month_year', $month_year);
        }])->get();

        return view('dues.index', compact('members', 'month_year', 'title'));
    }

    public function store(Request $request)
    {
        // Proteksi backend: Pastikan hanya yang memiliki akses 'manage-dues' (Bendahara) yang bisa menyimpan data
        \Illuminate\Support\Facades\Gate::authorize('manage-dues');

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'month_year' => 'required|date_format:Y-m',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Lunas,Belum Lunas',
        ]);

        $data = $request->all();
        if ($data['status'] == 'Lunas') {
            $data['paid_at'] = now();
        } else {
            $data['paid_at'] = null;
        }

        Due::updateOrCreate(
            ['member_id' => $data['member_id'], 'month_year' => $data['month_year']],
            ['amount' => $data['amount'], 'status' => $data['status'], 'paid_at' => $data['paid_at']]
        );

        return back()->with('success', 'Data iuran berhasil disimpan.');
    }
}
