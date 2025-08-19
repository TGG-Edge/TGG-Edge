<?php

namespace App\Http\Controllers\TggIndia\Member;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Link;
use App\Models\Module;
use App\Models\ModuleFeature;
use App\Models\ModuleInstance;
use App\Models\UserSecondary;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    //
    public function index()
    {
        // $modules = Module::with('users')->latest()->get();
        $modules = Module::latest()->get();
        return view('tgg-india.admin.modules.investments.index', compact('modules'));
    }

    public function chapters(Chapter $chapter,$id)
    {
        // Eager load section and literature]
        $chapter = Chapter::find($id);
        $chapter->load('section.literature');

        return view('tgg-india.member.modules.investments.chapters', compact('chapter'));
    }

    public function links()
    {
        //
        $links = Link::paginate(5);
        return view('tgg-india.member.modules.investments.links', compact('links'));
    }

    public function videos()
    {
        //
        $videos = Video::paginate(5);
        return view('tgg-india.member.modules.investments.videos', compact('videos'));
    }
}
