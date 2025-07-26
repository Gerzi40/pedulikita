<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        return view('organizations.admin_index');
    }

    private function filter(Builder $query, Request $request)
    {

    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {

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
        return view('organizations.admin_show');
    }

    public function edit(string $id)
    {
        return view('organizations.edit');
    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}
