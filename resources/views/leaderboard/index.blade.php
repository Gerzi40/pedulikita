<div class="max-w-4xl mx-auto p-6 bg-white">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">LEADERBOARD</h1>

    <div class="flex border-b border-gray-300 mb-10">
        <button class="tab-btn px-4 py-2 text-black border-b-2 border-black hover:text-black cursor-pointer" data-tab="all">
            All Time
        </button>
        <button class="tab-btn px-4 py-2 text-gray-600 border-b-2 border-transparent hover:text-black cursor-pointer" data-tab="yearly">
            Yearly
        </button>
        <button class="tab-btn px-4 py-2 text-gray-600 border-b-2 border-transparent hover:text-black cursor-pointer" data-tab="monthly">
            Monthly
        </button>
    </div>

    <div id="tab-all" class="tab-content">
        <div class="flex justify-center items-end mb-8 space-x-4 gap-10">

            <div class="flex flex-col items-center">
                <div class="relative mb-2">
                    <img src="{{ Storage::disk('s3')->url($volunteers[1]->profile_picture_url) }}" alt="{{ $volunteers[1]->name }}" class="w-16 h-16 rounded-full border-2 border-gray-400">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <img src="{{ asset('assets/icons/rank2.png') }}" />
                    </div>
                </div>
                <h3 class="font-semibold text-sm text-gray-800">{{ $volunteers[1]->name }}</h3>
                <p class="text-xs text-gray-500">{{ $volunteers[1]->point_total }} poin</p>
            </div>

            <div class="flex flex-col items-center">
                <div class="relative mb-2">
                    <img src="{{ Storage::disk('s3')->url($volunteers[0]->profile_picture_url) }}" alt="{{ $volunteers[0]->name }}" class="w-20 h-20 rounded-full border-2 border-yellow-400">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <img src="{{ asset('assets/icons/rank1.png') }}" />
                    </div>
                </div>
                <h3 class="font-semibold text-base text-gray-800">{{ $volunteers[0]->name }}</h3>
                <p class="text-sm text-gray-500">{{ $volunteers[0]->point_total }} poin</p>
            </div>

            <div class="flex flex-col items-center">
                <div class="relative mb-2">
                    <img src="{{ Storage::disk('s3')->url($volunteers[2]->profile_picture_url) }}" alt="{{ $volunteers[2]->name }}" class="w-16 h-16 rounded-full border-2 border-amber-600">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <img src="{{ asset('assets/icons/rank3.png') }}" />
                    </div>
                </div>
                <h3 class="font-semibold text-sm text-gray-800">{{ $volunteers[2]->name }}</h3>
                <p class="text-xs text-gray-500">{{ $volunteers[2]->point_total }} poin</p>
            </div>

        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Peringkat selanjutnya</h2>
            </div>

            <div class="space-y-3">
                @foreach ($volunteers->slice(3) as $index => $volunteer)
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-semibold">
                                    {{ $index + 1 }}
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <img src="{{ Storage::disk('s3')->url($volunteer->profile_picture_url) }}" alt="{{ $volunteer->name }}" class="w-12 h-12 rounded-full">
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $volunteer->name }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-800">{{ $volunteer->point_total }}</p>
                            <p class="text-sm text-gray-500">poin</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="tab-yearly" class="tab-content hidden"></div>
    <div id="tab-monthly" class="tab-content hidden"></div>
</div>

<script>
    const tabBtns = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');
    let loaded = { all: true, yearly: false, monthly: false };

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            contents.forEach(c => c.classList.add('hidden'));
            tabBtns.forEach(b => {
                b.classList.remove('border-black', 'text-black')
                b.classList.add('text-gray-600', 'border-transparent')
            });

            const tabId = btn.dataset.tab;
            const container = document.getElementById('tab-' + tabId);
            btn.classList.add('border-black', 'text-black');
            btn.classList.remove('text-gray-600', 'border-transparent')
            container.classList.remove('hidden');

            if (!loaded[tabId]) {
                container.innerHTML = `<div class="text-gray-500 text-center">Loading...</div>`;

                fetch(`/leaderboard/${tabId}`)
                    .then(res => res.json())
                    .then(volunteers => {
                        
                        let volunteers_html = '';
                        volunteers.slice(3).forEach((volunteer, index) => {
                            volunteers_html += `
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-semibold">
                                                ${index + 4}
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <img src="{{ Storage::disk('s3')->url('${volunteer.profile_picture_url}') }}" alt="${volunteer.name}" class="w-12 h-12 rounded-full">
                                            <div>
                                                <h3 class="font-semibold text-gray-800">${volunteer.name}</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-xl font-bold text-gray-800">${volunteer.point_total}</p>
                                        <p class="text-sm text-gray-500">poin</p>
                                    </div>
                                </div>
                            `;
                        });

                        let html = `
                            <div class="flex justify-center items-end mb-8 space-x-4 gap-10">
                                <div class="flex flex-col items-center">
                                    <div class="relative mb-2">
                                        <img src="{{ Storage::disk('s3')->url('${volunteers[1].profile_picture_url}') }}" alt="${volunteers[1].name}" class="w-16 h-16 rounded-full border-2 border-gray-400">
                                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                            <img src="{{ asset('assets/icons/rank2.png') }}" />
                                        </div>
                                    </div>
                                    <h3 class="font-semibold text-sm text-gray-800">${volunteers[1].name}</h3>
                                    <p class="text-xs text-gray-500">${volunteers[1].point_total} poin</p>
                                </div>

                                <div class="flex flex-col items-center">
                                    <div class="relative mb-2">
                                        <img src="{{ Storage::disk('s3')->url('${volunteers[0].profile_picture_url}') }}" alt="${volunteers[0].name}" class="w-20 h-20 rounded-full border-2 border-yellow-400">
                                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                            <img src="{{ asset('assets/icons/rank1.png') }}" />
                                        </div>
                                    </div>
                                    <h3 class="font-semibold text-base text-gray-800">${volunteers[0].name}</h3>
                                    <p class="text-sm text-gray-500">${volunteers[0].point_total} poin</p>
                                </div>

                                <div class="flex flex-col items-center">
                                    <div class="relative mb-2">
                                        <img src="{{ Storage::disk('s3')->url('${volunteers[2].profile_picture_url}') }}" alt="${volunteers[2].name}" class="w-16 h-16 rounded-full border-2 border-amber-600">
                                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                            <img src="{{ asset('assets/icons/rank3.png') }}" />
                                        </div>
                                    </div>
                                    <h3 class="font-semibold text-sm text-gray-800">${volunteers[2].name}</h3>
                                    <p class="text-xs text-gray-500">${volunteers[2].point_total} poin</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-lg font-semibold text-gray-800">Peringkat selanjutnya</h2>
                                </div>

                                <div class="space-y-3">
                                    ${volunteers_html}
                                </div>
                            </div>
                        `;

                        container.innerHTML = html;

                        loaded[tabId] = true;
                    });
            }
        });
    });
</script>