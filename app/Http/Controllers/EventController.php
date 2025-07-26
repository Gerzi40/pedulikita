<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function guest_index(Request $request)
    {
        return view('events.guest_index');
    }

    public function volunteer_index(Request $request)
    {
        return view('events.volunteer_index');
    }

    public function organization_index(Request $request)
    {
        return view('events.organization_index');
    }

    public function admin_index(Request $request)
    {
        return view('events.admin_index');
    }

    private function filter(Builder $query, Request $request)
    {

    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {

    }

    public function guest_show(string $id)
    {
        return view('events.guest_show');
    }

    public function volunteer_show(string $id)
    {
        return view('events.volunteer_show');   
    }

    public function organization_show(string $id)
    {
        return view('events.organization_show');
    }

    public function admin_show(string $id)
    {
        return view('events.admin_show');
    }

    public function edit(string $id)
    {
        return view('events.edit');
    }

    public function update(Request $request, string $id)
    {

    }

    public function organization_destroy(string $id)
    {

    }

    public function admin_destroy(string $id)
    {

    }

    public function approve(Request $request, string $id)
    {

    }

    public function reject(Request $request, string $id)
    {

    }
}
