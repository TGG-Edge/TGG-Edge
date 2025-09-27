<?php

use App\Http\Controllers\User\ResearchAssistanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorUploadController;
use App\Http\Controllers\LinkedinSearchController;
use UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Xguard\Kanban\Models\Board;
use Xguard\LaravelKanban\Models\Board as ModelsBoard;
use App\Http\Controllers\DataController;

// Route::get('sheet/upload', [DataController::class, 'showUploadForm'])->name('sheet.upload.form');
// Route::post('sheet/upload', [DataController::class, 'upload'])->name('sheet.upload');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('web')->get('/researcher/kanban', function () {

        $user = Auth::user();

        if (!$user || $user->user_role != 2) {
            abort(403, 'Only researchers can access this.');
        }

        // Step 1: Add to kanban_employees if not exists
        $employeeId = DB::table('kanban_employees')
            ->where('user_id', $user->id)
            ->value('id');

        if (!$employeeId) {
            $employeeId = DB::table('kanban_employees')->insertGetId([
                'user_id' => $user->id,
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Step 2: Assign to all boards as admin if not already assigned
        $boards = DB::table('kanban_boards')->pluck('id');

        foreach ($boards as $boardId) {
            $exists = DB::table('kanban_members')
                ->where('board_id', $boardId)
                ->where('employee_id', $employeeId)
                ->exists();

            if (!$exists) {
                DB::table('kanban_members')->insert([
                    'board_id' => $boardId,
                    'employee_id' => $employeeId,
                     // give full access
                ]);
            }
        }


})->name('researcher.kanban');

// Add this at the bottom of your routes/web.php
Route::get('/login', fn () => redirect()->route('user.login'))->name('login');

Route::get('/cron/generate-ai-research-assistance', [ResearchAssistanceController::class, 'CronGenerateRA']);

// routes/web.php
Route::post('/ckeditor/upload', [\App\Http\Controllers\UploadController::class, 'upload'])->name('ckeditor.upload');


Route::get('search/undergrad-researchers', [LinkedinSearchController::class, 'search']);

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::get('/phpinfo', function () {
    return phpinfo();
});