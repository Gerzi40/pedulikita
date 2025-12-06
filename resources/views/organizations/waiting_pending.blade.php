@extends('layouts.app')

@section('title', 'Waiting')

@section('content')

    <style>
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
    </style>

    <div class="page-bg" aria-hidden="true">
        <div class="wave left"></div>
        <div class="wave right"></div>
    </div>

    <div class="container">
        <div class="card" role="main" aria-labelledby="waiting-title">
            <div class="monitor">
                <img src="{{ asset('assets/general_image/waiting.gif') }}" alt="Waiting animation">
            </div>

            <div class="progress-wrap" aria-hidden="true">
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="72">
                    <div class="bar"></div>
                </div>
            </div>

            <h1 id="waiting-title" class="title">Menunggu persetujuan dari Admin</h1>
            <p class="note">
                Pendaftaran organisasi-mu sudah berhasil dibuat, dan sekarang dalam proses review dan approval oleh admin.
                Mohon dapat menunggu hingga proses review dan approval selesai.
            </p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-[var(--color1)] hover:bg-[var(--hovercolor1)] text-white text-sm transition font-medium">
                    Balik ke halaman sebelumnya?
                </button>
            </form>

        </div>
    </div>


@endsection
