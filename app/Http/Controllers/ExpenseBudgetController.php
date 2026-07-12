<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ExpenseBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class ExpenseBudgetController extends Controller
{
    public function index(Activity $activity)
    {
        $title = 'Anggaran & Realisasi: ' . $activity->name;
        $budgets = $activity->budgets()->get();
        
        $totalPlanned = $budgets->sum('planned_amount');
        $totalActual = $budgets->sum('actual_amount');

        return view('budgets.index', compact('activity', 'budgets', 'title', 'totalPlanned', 'totalActual'));
    }

    public function store(Request $request, Activity $activity)
    {
        Gate::authorize('manage-budgets');

        $request->validate([
            'item_name' => 'required|string|max:255',
            'planned_amount' => 'required|numeric|min:0',
        ]);

        $activity->budgets()->create([
            'item_name' => $request->item_name,
            'planned_amount' => $request->planned_amount,
        ]);

        return back()->with('success', 'Rencana anggaran berhasil ditambahkan.');
    }

    public function update(Request $request, Activity $activity, ExpenseBudget $budget)
    {
        Gate::authorize('manage-budgets');

        $request->validate([
            'actual_amount' => 'nullable|numeric|min:0',
            'receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('actual_amount');

        if ($request->hasFile('receipt')) {
            if ($budget->receipt_url) {
                Storage::disk('public')->delete($budget->receipt_url);
            }
            $data['receipt_url'] = $request->file('receipt')->store('receipts', 'public');
        }

        $budget->update($data);

        return back()->with('success', 'Realisasi anggaran berhasil diperbarui.');
    }

    public function destroy(Activity $activity, ExpenseBudget $budget)
    {
        Gate::authorize('manage-budgets');

        if ($budget->receipt_url) {
            Storage::disk('public')->delete($budget->receipt_url);
        }
        
        $budget->delete();

        return back()->with('success', 'Item anggaran berhasil dihapus.');
    }
}
