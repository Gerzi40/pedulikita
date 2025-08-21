@extends('layouts.organization')

@section('title', 'Acara')

@section('content')

    <form action="{{ route('organization.events.index') }}" method="get" id="filterForm">
        <div>
            <input type="text" name="name" value="{{ request('name') }}">
        </div>
        <div>
            <input type="date" name="date" value="{{ request('date') }}">
        </div>
        <div>
            <select name="province_id" id="province">
                <option></option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected(request('province_id') == $province->id)>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="city_id" id="city">
                <option></option>
            </select>
        </div>
        <div>
            <select name="state">
                <option></option>
                <option value="pending" @selected(request('state') == 'pending')>Pending</option>
                <option value="approved" @selected(request('state') == 'approved')>Approved</option>
                <option value="rejected" @selected(request('state') == 'rejected')>Rejected</option>
            </select>
        </div>

        <button type="submit">Cari</button>
    </form>

    @foreach ($events as $event)
        <li>{{ $event }}</li>
    @endforeach

    {{ $events->links() }}

    <script>
        const selectedCity = "{{ request('city_id') }}";

        $(document).ready(function() {
            $('#province').on('change', function() {
                const provinceId = $(this).val();

                if (provinceId) {
                    $.get(`/provinces/${provinceId}/cities`, function(data) {
                        let options = '<option></option>';
                        data.forEach(city => {
                            options +=
                                `<option value="${city.id}" ${selectedCity == city.id ? 'selected' : ''}>${city.name}</option>`;
                        });
                        $('#city').html(options);
                    });
                } else {
                    $('#city').html('<option></option>');
                }
            });

            if ($('#province').val()) {
                $('#province').trigger('change');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            if (!form) return;

            form.addEventListener('submit', function() {
                form.querySelectorAll('input[name], select[name]').forEach(el => {
                    if (!el.value || el.value.trim() === '') {
                        el.removeAttribute('name');
                    }
                });
            });
        });
    </script>

@endsection
