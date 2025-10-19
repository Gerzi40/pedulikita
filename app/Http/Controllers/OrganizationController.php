<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use App\Models\OrganizationCategory;
use App\Models\Province;
use App\Models\User;
use App\Notifications\OrganizationApproved;
use App\Notifications\OrganizationCreated;
use App\Notifications\OrganizationRejected;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Throwable;

class OrganizationController extends Controller
{
    public function guest_index(Request $request)
    {
        return view('organizations.guest_index');
    }

    public function volunteer_index(Request $request)
    {
        return view('organizations.volunteer_index');
    }

    public function admin_index(Request $request)
    {
        $query = Organization::query();
        $organizations = $this->filter($query, $request);
        $organization_categories = OrganizationCategory::get();
        $provinces = Province::get();
        return view('organizations.admin_index', compact('organizations', 'organization_categories', 'provinces'));
    }

    private function filter(Builder $query, Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string'],
            'organization_category_id' => ['nullable', 'exists:organization_categories,id'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'state' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])]
        ]);

        $query->join('cities', 'organizations.city_id', '=', 'cities.id')
            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
            ->join('users', 'organizations.user_id', '=', 'users.id')
            ->select([
                'organizations.id',
                'users.name',
                'users.profile_picture_url',
                'organizations.founded_at',
                'organizations.state',
                'organizations.description',
                'users.email',
                'organizations.phone',
                'provinces.name as province_name',
                'cities.name as city_name'
            ]);

        if (!empty($validated['name'])) {
            $query->where('users.name', 'ilike', '%' . $validated['name'] . '%');
        }
        if (!empty($validated['organization_category_id'])) {
            $query->where('organizations.organization_category_id', '=', $validated['organization_category_id']);
        }
        if (!empty($validated['province_id'])) {
            if (!empty($validated['city_id'])) {
                $query->where('organizations.city_id', '=', $validated['city_id']);
            } else {
                $query->where('cities.province_id', '=', $validated['province_id']);
            }
        }
        if (!empty($validated['state']))
        {   
            $query->where('organizations.state', '=', $validated['state']);
        }

        return $query->paginate(12)->appends(request()->query());
    }

    public function create()
    {
        $organization_categories = OrganizationCategory::get();
        $provinces = Province::get();
        return view('organizations.create', compact('organization_categories', 'provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'lowercase', 'email', 'unique:users,email', 'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,}$/'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'profile_picture' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'organization_category_id' => ['required', 'exists:organization_categories,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                    $query->where('province_id', $request->province_id);
                })
            ],
            'description' => ['required', 'string'],
            'founded_at' => ['required', Rule::date()->beforeOrEqual(today())],
            'instagram' => ['required', 'string'],
            'phone' => ['required', 'digits_between:8,15']
        ]);

        $path = Storage::disk('s3')->putFile('profiles/organizations', $request->file('profile_picture'));
        if (!$path) {
            abort(500);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                ...Arr::only($validated, ['name', 'email', 'password']),
                'role' => 'organization',
                'profile_picture_url' => $path
            ]);
            $organization = Organization::create([
                ...Arr::only($validated, ['organization_category_id', 'city_id', 'description', 'founded_at', 'instagram', 'phone']),
                'user_id' => $user->id
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        try
        {
            $admins = User::where('role', '=', 'admin')->get();

            Notification::send($admins, new OrganizationCreated($user->name, $organization->id));
        }
        catch (Throwable $e)
        {
            Log::error($e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);
        
        return redirect()->route('organization.events.index');
    }

    public function guest_show(string $id)
    {
        return view('organizations.guest_show');
    }

    public function volunteer_show(string $id)
    {
        return view('organizations.volunteer_show');
    }

    public function admin_show(string $id)
    {
        $organization = Organization::findOrFail($id);
        return view('organizations.admin_show', compact('organization'));
    }

    public function destroy(string $id)
    {
        $organization = Organization::findOrFail($id);

        try
        {
            $organization->delete();
            $organization->user->delete();
            $organization->volunteers()->detach();
            
            Event::where('organization_id', '=', $organization->id)
                ->where('state', '!=', 'finished')
                ->delete();

            DB::commit();
        }
        catch (Throwable $e)
        {
            DB::rollBack();
            
            throw $e;
        }

        return redirect()->route('admin.organizations.index');
    }

    public function approve(string $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->state = 'approved';
        $organization->save();

        try
        {
            $organization->user->notify(new OrganizationApproved());
        }
        catch (Throwable $e)
        {
            Log::error($e->getMessage());
        }

        return back();
    }

    public function reject(string $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->state = 'rejected';
        $organization->save();

        try
        {
            $organization->user->notify(new OrganizationRejected());
        }
        catch (Throwable $e)
        {
            Log::error($e->getMessage());
        }

        return back();
    }

    public function waiting()
    {
        return view('organizations.waiting');
    }
}
