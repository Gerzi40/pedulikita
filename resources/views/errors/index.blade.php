@extends($layout)

@section('title', 'Error')

@section('content')
<div class="min-h-screen absolute top-0 right-0 bottom-0 left-0 flex items-center justify-center bg-white px-4">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-blue-600 mb-4">{{ $statusCode }}</h1>
        <h3 class="text-lg font-medium text-gray-800">{{ $message }}</h3>
    </div>
</div>
@endsection
