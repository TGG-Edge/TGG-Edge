<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(10);
        $user = auth('web2')->user();
        return view('tgg-india.templates.index', compact('templates','user'));
    }

    public function create()
    {
        return view('tgg-india.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'type'   => 'required|in:email,whatsapp,sms,notification',
            'body'   => 'required',
            'status' => 'required',
        ]);

        Template::create([
            'name'       => $request->name,
            'type'       => $request->type,
            'title'      => $request->title,
            'invite_link' => $request->invite_link,
            'content'    => [
                'body' => $request->body,
                'variables' => $request->variables ? explode(',', $request->variables) : []
            ],
            'created_by' => Auth::guard('web2')->id(),
            'status'     => $request->status,
        ]);

        $user = auth('web2')->user();
        return redirect()->route('tgg-india.templates.index',[$user->role_key])
            ->with('success', 'Template created successfully');
    }

    public function show($id)
    {
        $template = Template::findOrFail($id);
        $user = auth('web2')->user();
        return view('tgg-india.templates.show', compact('template'));
    }

    public function edit($id)
    {
        $template = Template::findOrFail($id);
        $user = auth('web2')->user();
        return view('tgg-india.templates.edit', compact('template','user'));
    }

    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'type'   => 'required',
            'body'   => 'required',
            'status' => 'required',
        ]);

        $template->update([
            'name'    => $request->name,
            'type'    => $request->type,
            'title'   => $request->title,
            'invite_link' => $request->invite_link,
            'content' => [
                'body' => $request->body,
                'variables' => $request->variables ? explode(',', $request->variables) : []
            ],
            'status'  => $request->status,
        ]);

        $user = auth('web2')->user();
        return redirect()->route('tgg-india.templates.index',[$user->role_key])
            ->with('success', 'Template updated successfully');
    }

    public function destroy($id)
    {
        Template::findOrFail($id)->delete();
        return back()->with('success', 'Template deleted successfully');
    }
}
