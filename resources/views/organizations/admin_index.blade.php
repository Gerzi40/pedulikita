@extends('layouts.admin')

@section('title', 'Admin Organizations Index')

@section('content')
    {{-- <div class="flex justify-center">
        <form action="{{ route('admin.organizations.index') }}" method="get" id="filterForm"
            class="flex flex-wrap gap-5 items-center p-5 bg-white shadow rounded-md justify-center my-5">

            <!-- Search Bar -->
            <div class="flex items-center rounded-md px-3 py-2 w-full md:w-auto bg-gray-200">
                <input type="text" name="name" placeholder="Masukkan nama organisasi"
                    class="outline-none w-full bg-transparent" value="{{ request('name') }}">
                <button type="submit" class="text-blue-500">🔍</button>
            </div>

            <!-- Organization Category -->
            <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
                🏷️
                <select name="organization_category_id" class="bg-transparent outline-none">
                    <option value="">Kategori Organisasi</option>
                    @foreach ($organization_categories as $organization_category)
                        <option value="{{ $organization_category->id }}" @selected(request('organization_category_id') == $organization_category->id)>
                            {{ $organization_category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Province Dropdown -->
            <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
                🏙️
                <select name="province_id" id="province" class="bg-transparent outline-none">
                    <option value="">Provinsi</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" @selected(request('province_id') == $province->id)>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- City Dropdown -->
            <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
                🌆
                <select name="city_id" id="city" class="bg-transparent outline-none">
                    <option value="">Kota</option>
                    <!-- Data kota dimuat via JS tergantung provinsi -->
                </select>
            </div>

            <!-- Filter Button -->
            <button type="submit" class="bg-[var(--color1)] text-white px-5 py-2 rounded-md hover:bg-[var(--hovercolor1)]">
                Filter
            </button>
        </form>
    </div> --}}

    <div class="ml-5 mb-5 mt-5">
        <a href="{{ route('admin.organizations.create') }}"
            class="px-4 py-2 bg-[var(--color1)] text-white text-sm font-semibold rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Buat
            Organisasi</a>
    </div>

    {{-- @foreach ($organizations as $organization)
        <li>
            <a href="{{ route('admin.organizations.show', ['id' => $organization->id]) }}">
                {{ $organization }}
            </a>
        </li>
    @endforeach --}}

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Organizations Management</h3>
            <p class="text-sm text-gray-600 mt-1">Manage and monitor volunteer organizations</p>
        </div>

        <!-- Table Container with horizontal scroll -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                            Organization Details</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px]">
                            Description</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Location</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[180px]">
                            Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Phone</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Founded</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($organizations as $key => $organization)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Row Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-medium text-gray-600">
                                    {{ $key + 1 }}
                                </div>
                            </td>

                            <!-- Organization Details -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if ($organization->profile_picture_url)
                                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                                src="{{ Storage::disk('s3')->url($organization->profile_picture_url) }}"
                                                alt="{{ $organization->name }}"
                                                onerror="this.src='https://via.placeholder.com/48x48/E5E7EB/9CA3AF?text={{ substr($organization->name, 0, 2) }}'">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-600">
                                                    {{ substr($organization->name, 0, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-semibold text-gray-900 leading-tight">
                                            {{ Str::limit($organization->name, 25) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 leading-relaxed">
                                    {{ Str::limit($organization->description, 60) }}
                                </div>
                            </td>

                            <!-- Location -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center text-sm font-medium text-gray-900">
                                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $organization->city_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $organization->province_name }}</div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <div>
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            {{ $organization->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Phone Number -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center space-y-1">
                                    @if (isset($organization->phone))
                                        <div class="flex items-center text-sm text-gray-900">
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            <div>
                                                {{ $organization->phone }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Founded Date -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center space-y-1">
                                    <div class="inline-flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($organization->founded_at)->locale('id')->isoFormat('D MMM YYYY') }}
                                    </div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.organizations.show', ['id' => $organization->id]) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-150 group"
                                        title="View Organization">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.organizations.edit', ['id' => $organization->id]) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition-colors duration-150 group"
                                        title="Edit Organization">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.organizations.destroy', ['id' => $organization->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this organization? This action cannot be undone.')"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-150 group"
                                            title="Delete Organization">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State (if no organizations) -->
        @if ($organizations->isEmpty())
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No organizations found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding a new organization.</p>
            </div>
        @endif

        <!-- Pagination (if you're using pagination) -->
        @if (method_exists($organizations, 'links'))
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $organizations->links() }}
            </div>
        @endif
    </div>

    {{ $organizations->links() }}

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
