@extends('layouts.organization')

@section('title', 'Ubah Profil')

@section('content')

    <form action="{{ route('organization.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div>
            <label>Nama Organisasi</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required />
        </div>
        <div>
            <label>Jenis Organisasi</label>
            <select name="organization_category_id" required>
                @foreach ($organization_categories as $organization_category)
                    <option value="{{ $organization_category->id }}" @selected(old('organization_category_id', $user->organization->organization_category_id) == $organization_category->id)>
                        {{ $organization_category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Provinsi</label>
            <select name="province_id" id="province" required>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected(old('province_id', $user->organization->city->province_id) == $province->id)>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Kota</label>
            <select name="city_id" id="city" required>
                @foreach ($user->organization->city->province->cities as $city)
                    <option value="{{ $city->id }}" @selected(old('city_id', $user->organization->city_id) == $city->id)>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Tanggal Didaftarkan</label>
            <input type="date" name="founded_at" value="{{ old('founded_at', $user->organization->founded_at) }}" required />
        </div>

        <div>
            <label>Instagram</label>
            <input type="text" name="instagram" value="{{ old('instagram', $user->organization->instagram) }}" required />
        </div>
        <div>
            <label>Nomor Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $user->organization->phone) }}" required />
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required />
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" />
        </div>
        <div>
            <label>Keterangan</label>
            <textarea name="description" rows="4" required>{{ old('description', $user->organization->description) }}</textarea>
        </div>
        <div>
            <label>Foto Profil</label>
            <input type="file" name="profile_picture" accept="image/*" />
        </div>

        <button type="submit">Ubah</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script>
        $('#province').on('change', function() {
            const provinceId = $(this).val();

            if (provinceId) {
                $.get(`/provinces/${provinceId}/cities`, function(data) {
                    let options = '<option hidden></option>';
                    data.forEach(city => {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    });
                    $('#city').html(options);
                });
            } else {
                $('#city').html('<option hidden></option>');
            }
        });
    </script>

@endsection
