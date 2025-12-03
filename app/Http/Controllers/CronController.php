<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CronController extends Controller
{
    public function block_rejected_organization()
    {
        Organization::where('rejected_at', '<=', Carbon::now()->subMonths(1))->where('state', '=', 'rejected')->update(['state' => 'blocked']);
    }
}
