<?php

namespace App\Http\Controllers;

use App\Jobs\CheckEmailJob;
use App\Models\CampaignCheckEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

class EmailCheckController extends Controller
{
    //
     public function index($role)
    {
        $emails = CampaignCheckEmail::latest()->paginate(20);
        if(auth('web2')->user()->role_key == 'freelancer'){
            $emails = CampaignCheckEmail::where('created_by', auth('web2')->id())
                ->latest()
                ->paginate(10);
        }
        return view('tgg-india.email-check.index', compact('emails', 'role'));
    }

    public function create($role)
    {
        return view('tgg-india.email-check.create', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $rows = Excel::toArray([], $request->file('excel_file'))[0];
        $headers = array_map('strtolower', array_shift($rows));

        foreach ($rows as $row) {

            $data = array_combine($headers, $row);
            if (empty($data['email'])) continue;

            CheckEmailJob::dispatch($data, auth('web2')->id());

            // // 🔹 DISIFY API CALL
            // $response = Http::get('https://www.disify.com/api/email/' . $data['email']);

            // if (!$response->ok()) continue;

            // $res = $response->json();

            // // 🔹 FINAL VALID LOGIC
            // $isValid =
            // isset($res['format'], $res['disposable'], $res['dns']) &&
            // $res['format'] === true &&
            // $res['dns'] === true &&
            // $res['disposable'] === false;

            // CampaignCheckEmail::create([
            //     'name'       => $data['name'] ?? null,
            //     'email'      => $data['email'],
            //     'is_valid'      => $isValid ? 1 : 0,
            //     'format'     => $res['format'] ?? 0,
            //     'domain'     => $res['domain'] ?? null,
            //     'disposable' => $res['disposable'] ?? 0,
            //     'dns'        => $res['dns'] ?? 0,
            //     'whitelist'  => $res['whitelist'] ?? 0,
            //     'created_by' => auth('web2')->id(),
            // ]);
        }

        $user = auth('web2')->user();
        return redirect()
            ->route('tgg-india.email-check.index', [$user->role_key])
            ->with('success', 'Email verification completed');
    }

    public function show($role, $id)
    {
        $email = CampaignCheckEmail::findOrFail($id);
        return view('tgg-india.email-check.show', compact('email', 'role'));
    }

    public function downloadValid()
    {
        $emails = CampaignCheckEmail::where('is_valid', 1)->get();

        return Excel::download(new class($emails) implements FromCollection {
            private $emails;

            public function __construct($emails)
            {
                $this->emails = $emails;
            }

            public function collection()
            {
                return $this->emails->map(function ($e) {
                    return [
                        'name'  => $e->name,
                        'email' => $e->email,
                    ];
                });
            }
        }, 'valid_emails.xlsx');
    }

    public function destroy($id)
    {
        CampaignCheckEmail::findOrFail($id)->delete();
        return back()->with('success', 'Campaign Check Email deleted successfully');
    }
}
