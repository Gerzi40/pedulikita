<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\profile\OrganizationController as ProfileOrganizationController;
use App\Http\Controllers\profile\VolunteerController as ProfileVolunteerController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('guest.index');
    
    Route::controller(EventController::class)->group(function () {
        Route::get('/events', 'guest_index')->name('guest.events.index');
        Route::get('/events/{id}', 'guest_show')->name('guest.events.show');
    });
    
    Route::controller(OrganizationController::class)->group(function () {
        Route::get('/organizations', 'guest_index')->name('guest.organizations.index');
        Route::get('/organizations/{id}', 'guest_show')->name('guest.organizations.show');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:volunteer'])->group(function () {
        Route::controller(EventController::class)->group(function () {
            Route::get('/volunteer/events', 'volunteer_index')->name('volunteer.events.index');
            Route::get('/volunteer/events/{id}', 'volunteer_show')->name('volunteer.events.show');
        });

        Route::controller(OrganizationController::class)->group(function () {
            Route::get('/volunteer/organizations', 'volunteer_index')->name('volunteer.organizations.index');
            Route::get('/volunteer/organizations/{id}', 'volunteer_show')->name('volunteer.organizations.show');
        });

        Route::controller(ProfileVolunteerController::class)->group(function () {
            Route::get('/volunteer/profile', 'show')->name('volunteer.profile.show');
            Route::get('/volunteer/profile/edit', 'edit')->name('volunteer.profile.edit');
            Route::put('/volunteer/profile', 'update')->name('volunteer.profile.update');
        });
        
        Route::controller(FollowController::class)->group(function () {
            Route::get('/volunteer/following', 'volunteer_index')->name('volunteer.follow.index');
            Route::post('/volunteer/follow/{organization_id}', 'store')->name('volunteer.follow.store');
            Route::delete('volunteer/follow/{organization_id}', 'destroy')->name('volunteer.follow.destroy');
        });
        
        Route::controller(ParticipationController::class)->group(function () {
            Route::get('/volunteer/activity', 'volunteer_index')->name('volunteer.participation.index');
            Route::post('/volunteer/events/{event_id}', 'store')->name('volunteer.participation.store');
        });

        Route::get('/volunteer/leaderboard', [LeaderboardController::class, 'volunteer_index'])->name('volunteer.leaderboard.index');
    });

    Route::middleware(['role:organization'])->group(function () {
        Route::controller(EventController::class)->group(function () {
            Route::get('/organization/events', 'organization_index')->name('organization.events.index');
            Route::get('/organization/events/create', 'create')->name('organization.events.create');
            Route::post('/organization/events', 'store')->name('organization.events.store');
            Route::get('/organization/events/{id}', 'organization_show')->name('organization.events.show');
            Route::get('/organization/events/{id}/edit', 'edit')->name('organization.events.edit');
            Route::put('/organization/events/{id}', 'update')->name('organization.events.update');
            Route::delete('/organization/events/{id}', 'organization_destroy')->name('organization.events.destroy');
        });

        Route::controller(ParticipationController::class)->group(function () {
            Route::get('/organization/events/{event_id}/volunteer', 'organization_index')->name('organization.participation.index');
            Route::put('/organization/events/{event_id}/volunteer/{volunteer_id}', 'update')->name('organization.participation.update');
        });

        Route::controller(ProfileOrganizationController::class)->group(function () {
            Route::get('/organization/profile', 'show')->name('organization.profile.show');
            Route::get('/organization/profile/edit', 'edit')->name('organization.profile.edit');
            Route::put('/organization/profile', 'update')->name('organization.profile.update');
        });

        Route::get('/organization/leaderboard', [LeaderboardController::class, 'organization_index'])->name('organization.leaderboard.index');
        Route::get('/organization/follower', [FollowController::class, 'organization_index'])->name('organization.follow.index');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::controller(EventController::class)->group(function () {
            Route::get('/admin/events', 'admin_index')->name('admin.events.index');
            Route::get('/admin/events/{id}', 'admin_show')->name('admin.events.show');
            Route::delete('/admin/events/{id}', 'admin_destroy')->name('admin.events.destroy');
            Route::put('/admin/events/{id}/approve', 'approve')->name('admin.events.approve');
            Route::put('/admin/events/{id}/reject', 'reject')->name('admin.events.reject');
        });

        Route::controller(OrganizationController::class)->group(function () {
            Route::get('/admin/organizations', 'admin_index')->name('admin.organizations.index');
            Route::get('/admin/organizations/create', 'create')->name('admin.organizations.create');
            Route::post('/admin/organizations', 'store')->name('admin.organizations.store');
            Route::get('/admin/organizations/{id}', 'admin_show')->name('admin.organizations.show');
            Route::get('/admin/organizations/{id}/edit', 'edit')->name('admin.organizations.edit');
            Route::put('/admin/organizations/{id}', 'update')->name('admin.organizations.update');
            Route::delete('/admin/organizations/{id}', 'destroy')->name('admin.organizations.destroy');
        });

    });
});

Route::get('/provinces/{id}/cities', [ProvinceController::class, 'cities']);

require __DIR__.'/auth.php';
