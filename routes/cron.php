<?php

use App\Http\Controllers\CronController;
use Illuminate\Support\Facades\Route;

Route::get('/cron/block-rejected-organization', [CronController::class, 'block_rejected_organization']);
Route::get('/cron/populate-volunteer-point-rating', [CronController::class, 'populate_volunteer_point_rating']);
