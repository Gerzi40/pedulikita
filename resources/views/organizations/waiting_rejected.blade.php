@extends('layouts.app') @section('title', 'Waiting') @section('content') <style>
    :root {
        --blue-1: #0546d6;
        --blue-2: #00b4ff;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
    }

    body {
        font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        margin: 0;
        background: linear-gradient(180deg, #fbfdff 0%, #f2f6fb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px;
    }

    .page-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    .wave {
        position: absolute;
        width: 480px;
        height: 1100px;
        background: linear-gradient(180deg, var(--blue-1), var(--blue-2));
        border-radius: 50%;
        filter: blur(6px);
        opacity: 0.95;
    }

    .wave.left {
        left: -260px;
        top: -240px;
        transform: rotate(20deg);
    }

    .wave.right {
        right: -260px;
        bottom: -240px;
        transform: rotate(-20deg);
    }

    .container {
        position: relative;
        z-index: 1;
        width: 920px;
        max-width: 94%;
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }

    .card {
        width: 820px;
        background: #e9e9ea;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(12, 20, 40, 0.12);
        padding: 18px;
        overflow: visible;
    }

    .monitor {
        background: #ffffff;
        border-radius: 10px;
        border: 6px solid rgba(200, 200, 200, 0.55);
        height: 360px;
        overflow: hidden;
        position: relative;
    }

    .monitor img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .progress-wrap {
        margin-top: 14px;
        padding: 6px 8px;
    }

    .progress {
        height: 12px;
        background: #dfeffb;
        border-radius: 999px;
        overflow: hidden;
        border: 4px solid rgba(0, 0, 0, 0.04);
        box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0.03);
    }

    .progress>.bar {
        height: 100%;
        width: 72%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--blue-1), var(--blue-2));
        animation: progress-anim 2.2s ease-in-out infinite alternate;
    }

    @keyframes progress-anim {
        from {
            transform: translateX(-2%);
        }

        to {
            transform: translateX(0%);
        }
    }

    .title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 14px 8px 6px 8px;
    }

    .note {
        color: #4b5563;
        font-size: 14px;
        margin: 0 8px 14px 8px;
        line-height: 1.45;
    }

    @media (max-width:920px) {
        .monitor {
            height: 240px;
            padding: 12px;
        }

        .card {
            width: 94%;
        }
    }

    @media (max-width: 640px) {

        body {
            padding: 16px;
        }

        /* container lebih kecil */
        .content-wrap {
            width: 100%;
            max-width: 100%;
        }

        /* countdown */
        .countdown-wrap h2 {
            font-size: 16px;
        }

        .countdown {
            gap: 20px;
        }

        .countdown span {
            font-size: 26px;
        }

        .countdown small {
            font-size: 11px;
        }

        /* monitor */
        .monitor {
            height: 200px;
            border-width: 4px;
            padding: 0;
        }

        /* text card */
        .title {
            font-size: 16px;
        }

        .note {
            font-size: 13px;
        }

        /* buttons jadi stack */
        .navigation {
            flex-direction: column;
            gap: 10px;
        }

        .navigation button,
        .navigation a {
            width: 100%;
            text-align: center;
        }

    }

    /* ===========================
   TABLET
============================*/

    @media (max-width: 920px) {

        .content-wrap {
            width: 100%;
        }

        .monitor {
            height: 240px;
        }

        .countdown span {
            font-size: 30px;
        }
    }

    .countdown-wrap {
        width: 100%;
        text-align: center;
        /* biar sejajar dengan card */
        padding-left: 8px;
        margin-bottom: 20px;
    }

    .countdown-wrap h2 {
        color: #2563eb;
        /* Biru */
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .countdown {
        display: flex;
        justify-content: center;
        gap: 48px;
    }

    .countdown div {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .countdown span {
        font-size: 42px;
        font-weight: 700;
        color: #2563eb;
        line-height: 1;
    }

    .countdown small {
        font-size: 14px;
        color: #2563eb;
    }

    .content-wrap {
        width: 820px;
        /* SAMA dengan .card */
        max-width: 94%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    @media (max-width:640px){

    /* countdown jadi panel putih */
    .countdown-wrap{
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(6px);
        border-radius: 16px;
        padding: 12px 8px;
        margin-bottom: 16px;
        box-shadow: 0 4px 14px rgba(0,0,0,.08);
    }

    /* teks gelap supaya kebaca */
    .countdown-wrap h2{
        color:#1e293b;
        font-size:14px;
    }

    .countdown span{
        color:#0b56cc;
        font-size:24px;
    }

    .countdown small{
        color:#334155;
        font-size:11px;
    }
}
</style>
<div class="page-bg" aria-hidden="true">
    <div class="wave left"></div>
    <div class="wave right"></div>
</div>
<div class="container">
    <div class="content-wrap">
        <div class="countdown-wrap">
            <h2>Mohon melakukan revisi dalam:</h2>

            <div class="countdown">
                <div>
                    <span id="cd-days">00</span>
                    <small>Hari</small>
                </div>
                <div>
                    <span id="cd-hours">00</span>
                    <small>Jam</small>
                </div>
                <div>
                    <span id="cd-minutes">00</span>
                    <small>Menit</small>
                </div>
            </div>
        </div>
        <div class="card" role="main" aria-labelledby="waiting-title">
            <div class="monitor"> <img src="{{ asset('assets/general_image/waiting.gif') }}" alt="Waiting animation">
            </div>
            <div class="progress-wrap" aria-hidden="true">
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="72">
                    <div class="bar"></div>
                </div>
            </div>
            <h1 id="waiting-title" class="title">Maaf, pengajuan organisasi Anda belum masuk dalam kriteria kami</h1>
            <p class="note"> {{ $organization->rejected_reason }} </p>
            <div class="navigation flex w-full justify-between items-center mt-4 gap-4">
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-5 py-2 rounded-full bg-[var(--color1)]
                           hover:bg-[var(--hovercolor1)]
                           text-white text-sm transition font-medium">
                            Balik ke halaman sebelumnya?
                        </button>
                    </form>
                </div>

                <div>
                    <a href="{{ route('organization.edit') }}"
                        class="px-5 py-2 rounded-full bg-[var(--color1)]
                       hover:bg-[var(--hovercolor1)]
                       text-white text-sm transition font-medium">
                        Revisi Pengajuan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const daysEl = document.getElementById("cd-days");
        const hoursEl = document.getElementById("cd-hours");
        const minutesEl = document.getElementById("cd-minutes");
        const wrap = document.querySelector(".countdown-wrap");

        if (!daysEl || !hoursEl || !minutesEl || !wrap) return;

        const rejectedAt = new Date("{{ \Carbon\Carbon::parse($organization->rejected_at)->toISOString() }}");

        let deadline = new Date(rejectedAt);
        deadline.setMonth(deadline.getMonth() + 1);

        function updateCountdown() {

            const now = new Date();
            const diff = deadline - now;

            if (diff <= 0) {
                wrap.innerHTML =
                    "<h2 style='color:red;font-weight:700;'>Masa revisi telah berakhir</h2>";
                return;
            }

            const totalMinutes = Math.floor(diff / 1000 / 60);
            const days = Math.floor(totalMinutes / 60 / 24);
            const hours = Math.floor((totalMinutes / 60) % 24);
            const minutes = totalMinutes % 60;

            daysEl.textContent = String(days).padStart(2, "0");
            hoursEl.textContent = String(hours).padStart(2, "0");
            minutesEl.textContent = String(minutes).padStart(2, "0");
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

    });
</script>
