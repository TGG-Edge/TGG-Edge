<?php

namespace App\Http\Controllers\TggIndia\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\UserSecondary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\MailTrait;

class ReceiptController extends Controller
{
    use MailTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $receipts = Receipt::with(['source', 'target'])->latest()->paginate(10);
        return view('tgg-india.admin.receipts.index', compact('receipts'));

    }

    public function create()
    {
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.admin.receipts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'source_id' => 'nullable',
            'target_id' => 'nullable',
            'issue_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'total' => 'nullable|numeric',
        ]);

        $receipt = Receipt::create([
            'receipt_number' => 'INV' . rand(10000, 99999),
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

        return redirect()->route('tgg-india.admin.receipts.index')->with('success', 'receipt created successfully.');
    
    }

    public function globalStore(Request $request)
    {
        $request->validate([
            'source_id'   => 'nullable',
            'target_id'   => 'nullable',
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
            $exists = Receipt::where('model_type', $request->model_type)
                            ->where('model_id', $request->model_id)
                            ->exists();
            if ($exists) {
                return redirect()->back()->with('error', 'Receipt already exists for this assignment.');
            }
        }

        // Create the Receipt
        $receipt = Receipt::create([
            'receipt_number' => 'INV' . rand(10000, 99999),
            'source_id'      => $request->source_id ?? auth('web2')->id(),
            'target_id'      => $request->target_id ?? 1,
            'issue_date'     => $request->issue_date ?? now(),
            'status'         => $request->status ?? 'completed',
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

        $receipt->items = $items;
        $receipt->save();

        $to = UserSecondary::where('id', $request->target_id)->first()->email;
        $subject = 'Congratulations! You’ve Received an Incentive - TGG India';
        $view = 'tgg-india.emails.tgg-template';
        $data = [
            'name' => $request['name'],
            'message' => 'Great news! You have received an incentive from TGG India as recognition for your outstanding performance and contribution. Please find the incentive details attached for your reference.',
        ];

        $pdfPath = $this->generatePdfFile($receipt->id);
        $attachments = [$pdfPath]; 

        $ok = $this->sendMail($to, $subject, $view, $data, $attachments);

        return redirect()->back()->with('success', 'Receipt created successfully.');
    }

    public function generatePdfFile($id)
    {
        $receipt = Receipt::with(['source', 'target'])->findOrFail($id);
        $pdf = Pdf::loadView('tgg-india.admin.receipts.pdf', compact('receipt'))
            ->setPaper('A4');
        $fileName = 'receipt_' . $receipt->receipt_number . '.pdf';
        $filePath = 'receipts/' . $fileName; 
        Storage::disk('public')->makeDirectory('receipts');
        Storage::disk('public')->put($filePath, $pdf->output());
        $receipt->update(['pdf_path' => $filePath]);
        return Storage::disk('public')->path($filePath);
    }

    public function show(Receipt $receipt,$id)
    {
        $receipt =   Receipt::findOrFail($id);
        return view('tgg-india.admin.receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $receipt = Receipt::findOrFail($id);
        $users = UserSecondary::select('id', 'name', 'email')->get();
        return view('tgg-india.admin.receipts.edit', compact('receipt', 'users'));
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

        return redirect()->route('tgg-india.admin.receipts.index')->with('success', 'receipt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(Receipt $receipt, $id)
    {
      
        $receipt = Receipt::with(['source', 'target'])->findOrFail($id);
        $pdf = Pdf::loadView('tgg-india.admin.receipts.pdf', compact('receipt'))
            ->setPaper('A4');
        $fileName = 'receipt_' . $receipt->receipt_number . '.pdf';
        $filePath = 'receipts/' . $fileName; 
        Storage::disk('public')->makeDirectory('receipts');
        Storage::disk('public')->put($filePath, $pdf->output());
        $receipt->update(['pdf_path' => $filePath]);
        return $pdf->download($fileName);
    }
}
