<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserSecondary;

class UserSecondaryController extends Controller
{
    public function getUsersFacilitator()
    {
        $users = UserSecondary::where('user_role', '8')
                    ->select('email','password')
                    ->get();

        return response()->json([
            'status' => true,
            'data' => $users
        ]);
    }
}