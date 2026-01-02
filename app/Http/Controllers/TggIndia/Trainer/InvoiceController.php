<?php

namespace App\Http\Controllers\TggIndia\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\UserSecondary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Container\Attributes\Auth;
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
        $invoices = Invoice::with(['source', 'target'])->where('source_id',auth('web2')->id())->latest()->paginate(10);
        return view('tgg-india.trainer.invoices.index', compact('invoices'));

    }

    public function create()
    {
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.trainer.invoices.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'issue_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'total' => 'nullable|numeric',
        ]);

        $invoice = Invoice::create([
            'invoice_number' => generateInvoiceNumber($request->source_id),
            'source_id' => Auth('web2')->id(),
            'target_id' => 1,
            'issue_date' => $request->issue_date,
            'status' => $request->status,
            'description' => $request->description,
            'total' => $request->total ?? null,
        ]);
        $items = $request->input('items', []);
        $invoice->items = $items;
        $invoice->save();
        return redirect()->route('tgg-india.trainer.invoices.index')->with('success', 'Invoice created successfully.');
    
    }

    public function globalStore(Request $request)
    {
        $request->validate([
            'source_id'   => 'nullable|exists:users,id',
            'target_id'   => 'nullable|exists:users,id',
            'issue_date'  => 'nullable|date',
            'status'      => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'total'       => 'nullable|numeric',
            'model_type'  => 'nullable|string|max:255',
            'model_id'    => 'nullable|integer',
            'title'       => 'nullable|string',
            'task_type'   => 'nullable|string',
            'price'       => 'nullable|numeric',
        ]);

        // Check if invoice already exists
        if ($request->model_type && $request->model_id) {
            $exists = Invoice::where('model_type', $request->model_type)
                            ->where('model_id', $request->model_id)
                            ->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'Invoice already exists for this assignment.');
            }
        }

        // Create the invoice
        $invoice = Invoice::create([
            'invoice_number' => 'INV' . rand(10000, 99999),
            'source_id'      => $request->source_id ?? auth('web2')->id(),
            'target_id'      => $request->target_id ?? 1,
            'issue_date'     => $request->issue_date ?? now(),
            'status'         => $request->status ?? 'pending',
            'total'          => $request->total ?? $request->price ?? 0,
            'model_type'     => $request->model_type ?? null,
            'model_id'       => $request->model_id ?? null,
        ]);

        // Prefill items if assignment info is passed
        $items = $request->input('items', []);

        if (!$items && $request->title && $request->price) {
            $items[] = [
                'description' => $request->title . ' (' . $request->task_type . ')',
                'amount'      => $request->price,
            ];
        }

        $invoice->items = $items;
        $invoice->save();

        return redirect()->back()->with('success', 'Invoice created successfully.');
    }



    public function show(Invoice $invoice,$id)
    {
        $invoice =   Invoice::findOrFail($id);
        return view('tgg-india.trainer.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        $users = UserSecondary::select('id', 'name', 'email')->get();
        if($invoice->status == 'paid'){
            return redirect()->back()->with('error', 'Can not edit this invoice, Invoice already paid.');
        }
        return view('tgg-india.trainer.invoices.edit', compact('invoice', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'issue_date' => $request->issue_date,
            'status' => $request->status,
            'description' => $request->description,
            'total' => $request->total ?? null,
        ]);

        $items = $request->input('items', []);
        $invoice->items = $items;
        $invoice->save();

        return redirect()->route('tgg-india.trainer.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->back()->with('success', 'Invoice deleted successfully.');
    }


    public function download(Invoice $invoice, $id)
    {
      
        $invoice = Invoice::with(['source', 'target'])->findOrFail($id);
        $pdf = Pdf::loadView('tgg-india.trainer.invoices.pdf', compact('invoice'))
            ->setPaper('A4');
        $fileName = 'Invoice_' . $invoice->invoice_number . '.pdf';
        $filePath = 'invoices/' . $fileName; 
        Storage::disk('public')->makeDirectory('invoices');
        Storage::disk('public')->put($filePath, $pdf->output());
        $invoice->update(['pdf_path' => $filePath]);
        return $pdf->download($fileName);
    }
}
