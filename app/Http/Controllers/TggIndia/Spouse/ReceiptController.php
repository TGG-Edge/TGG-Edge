<?php

namespace App\Http\Controllers\TggIndia\Spouse;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\UserSecondary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $receipts = Receipt::with(['source', 'target'])->latest()->paginate(10);
        return view('tgg-india.spouse.receipts.index', compact('receipts'));

    }

    public function create()
    {
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.spouse.receipts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'source_id' => 'nullable|exists:users,id',
            'target_id' => 'nullable|exists:users,id',
            'issue_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'total' => 'nullable|numeric',
        ]);

        $receipt = Receipt::create([
            'receipt_number' => generateReceiptNumber($request->source_id ?? auth('web2')->id()),
            'source_id' => $request->source_id,
            'target_id' => $request->target_id,
            'issue_date' => $request->issue_date,
            'status' => $request->status,
            'description' => $request->description,
            'total' => $request->total ?? null,
        ]);
        $items = $request->input('items', []);
        $receipt->items = $items;
        $receipt->save();

        return redirect()->route('tgg-india.spouse.receipts.index')->with('success', 'receipt created successfully.');
    
    }

    public function show(Receipt $receipt,$id)
    {
        $receipt =   Receipt::findOrFail($id);
        return view('tgg-india.spouse.receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $receipt = Receipt::findOrFail($id);
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.spouse.receipts.edit', compact('receipt', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $receipt = Receipt::findOrFail($id);

        $receipt->update([
            'source_id' => $request->source_id,
            'target_id' => $request->target_id,
            'issue_date' => $request->issue_date,
            'status' => $request->status,
            'description' => $request->description,
            'total' => $request->total ?? null,
        ]);

        $items = $request->input('items', []);
        $receipt->items = $items;
        $receipt->save();

        return redirect()->route('tgg-india.spouse.receipts.index')->with('success', 'receipt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receipt = Receipt::findOrFail($id);

        $receipt->delete();

        return redirect()
            ->back()
            ->with('success', 'Receipt deleted successfully.');
    }

    public function download(Receipt $receipt, $id)
    {
      
        $receipt = Receipt::with(['source', 'target'])->findOrFail($id);
        $pdf = Pdf::loadView('tgg-india.spouse.receipts.pdf', compact('receipt'))
            ->setPaper('A4');
        $fileName = 'receipt_' . $receipt->receipt_number . '.pdf';
        $filePath = 'receipts/' . $fileName; 
        Storage::disk('public')->makeDirectory('receipts');
        Storage::disk('public')->put($filePath, $pdf->output());
        $receipt->update(['pdf_path' => $filePath]);
        return $pdf->download($fileName);
    }
}
