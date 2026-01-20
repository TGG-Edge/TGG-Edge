<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignRecipient;
use App\Models\Template;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\SendCampaignEmailJob;
use Carbon\Carbon;

class CampaignController extends Controller
{
    //

     public function index()
    {
        $campaigns = Campaign::with('template')->latest()->paginate(10);
        if(auth('web2')->user()->role_key == 'freelancer' || auth('web2')->user()->role_key == 'facilitator'){
            $campaigns = Campaign::with('template')
                ->where('created_by', auth('web2')->id())
                ->latest()
                ->paginate(10);
        }
        return view('tgg-india.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $templates = Template::where('status', 'active')->get();
        return view('tgg-india.campaigns.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required',
            'excel_file'  => 'required|mimes:xlsx,xls,csv',
        ]);

        $is_email_limit_exceeded = false;
        $check_email_limit_exceeded = CampaignRecipient::where('created_at', '>=', Carbon::today())
                ->where('status', 'sent')
                ->count();

        if ($check_email_limit_exceeded >= 200) {
            $is_email_limit_exceeded = true;
        }

        if ($is_email_limit_exceeded) {
            return redirect()
                ->route('tgg-india.campaigns.index', [auth('web2')->user()->role_key])
                ->with('error', 'Campaign can not  be created, Email limit for today has been reached. Campaign will be created tomorrow.');
        }

        $campaign = Campaign::create([
            'template_id' => $request->template_id,
            'created_by'  => Auth::guard('web2')->id(),
            'type'        => 'email',
            'status'      => 'pending',
        ]);

        // Read Excel
        $rows = Excel::toArray([], $request->file('excel_file'))[0];
        $headers = array_map('strtolower', array_shift($rows));

        $is_email_limit_exceeded = false;
        $delaySeconds = 0;
        foreach ($rows as $row) {

            $check_email_limit_exceeded = CampaignRecipient::where('created_at', '>=', Carbon::today())
                ->where('status', 'sent')
                ->count();

            if ($check_email_limit_exceeded >= 200) {
                $is_email_limit_exceeded = true;
                break;
            }

            $data = array_combine($headers, $row);
            $recipient = CampaignRecipient::create([
                'campaign_id' => $campaign->id,
                'payload'     => $data,
                'status'      => 'pending',
            ]);

            // 🔹 Send Email (basic sync version)
            // $this->sendMail($campaign, $data);
            // ✅ Queue job
            SendCampaignEmailJob::dispatch($recipient->id)->delay(now()->addSeconds($delaySeconds));
            $delaySeconds += 5;

        }

        if ($is_email_limit_exceeded) {
            return redirect()
                ->route('tgg-india.campaigns.index', [auth('web2')->user()->role_key])
                ->with('error', 'Campaign created but email limit for today has been reached. Remaining emails will be sent tomorrow.');
        }

        $campaign->update(['status' => 'completed']);

        $user = auth('web2')->user();
        return redirect()
            ->route('tgg-india.campaigns.index',[$user->role_key])
            ->with('success', 'Campaign executed successfully');
    }

    private function sendMail($campaign, $data)
    {
        $template = $campaign->template;
        $body = $template->content['body'];

        foreach ($data as $key => $value) {
            $body = str_replace('{{'.$key.'}}', $value, $body);
        }

        if (!isset($data['email'])) return;

        Mail::html($body, function ($message) use ($data, $template) {
            $message->to($data['email'])
                    ->subject($template->title ?? 'Notification');
        });

        // $to = $data['email'];
        // $subject = $template->title;
        // $view = $body;

        // $ok = $this->sendMail($to, $subject, $view);
    }

    public function show($role, $id)
    {
        $campaign = Campaign::with([
            'template',
            'recipients'
        ])->findOrFail($id);

        return view('tgg-india.campaigns.show', compact('campaign'));
    }

    public function destroy($id)
    {
        Campaign::findOrFail($id)->delete();
        return back()->with('success', 'Campaign deleted successfully');
    }

}
