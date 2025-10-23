<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\UserSecondary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoices = Invoice::with(['source', 'target'])->latest()->paginate(10);
        return view('tgg-india.admin.invoices.index', compact('invoices'));

    }

    public function create()
    {
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.admin.invoices.create', compact('users'));
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

        $invoice = Invoice::create([
            'invoice_number' => 'INV' . rand(10000, 99999),
            'source_id' => $request->source_id,
            'target_id' => $request->target_id,
            'issue_date' => $request->issue_date,
            'status' => $request->status,
            'description' => $request->description,
            'total' => $request->total ?? null,
        ]);
        $items = $request->input('items', []);
        $invoice->items = $items;
        $invoice->save();

        return redirect()->route('tgg-india.admin.invoices.index')->with('success', 'Invoice created successfully.');
    
    }

    public function show(Invoice $invoice,$id)
    {
        $invoice =   Invoice::findOrFail($id);
        return view('tgg-india.admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.admin.invoices.edit', compact('invoice', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'source_id' => $request->source_id,
            'target_id' => $request->target_id,
            'issue_date' => $request->issue_date,
            'status' => $request->status,
            'description' => $request->description,
            'total' => $request->total ?? null,
        ]);

        $items = $request->input('items', []);
        $invoice->items = $items;
        $invoice->save();

        return redirect()->route('tgg-india.admin.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(Invoice $invoice, $id)
    {
      
        $invoice = Invoice::with(['source', 'target'])->findOrFail($id);
        $pdf = Pdf::loadView('tgg-india.admin.invoices.pdf', compact('invoice'))
            ->setPaper('A4');
        $fileName = 'Invoice_' . $invoice->invoice_number . '.pdf';
        $filePath = 'invoices/' . $fileName; 
        Storage::disk('public')->makeDirectory('invoices');
        Storage::disk('public')->put($filePath, $pdf->output());
        $invoice->update(['pdf_path' => $filePath]);
        return $pdf->download($fileName);
    }
}
