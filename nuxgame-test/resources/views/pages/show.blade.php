@extends('layouts.app')

@section('title', 'LuckyRoll — Your Page')

@push('styles')
    <style>
        .page-wrap {
            display: flex;
            justify-content: center;
            min-height: 100vh;
            padding: 3rem 1rem;
        }

        .page-inner {
            width: 100%;
            max-width: 520px;
        }

        /* ── Header ── */
        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .avatar {
            align-items: center;
            background: linear-gradient(135deg, var(--gold), #7a5520);
            border-radius: 50%;
            color: #0a0608;
            display: inline-flex;
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 600;
            height: 56px;
            justify-content: center;
            margin-bottom: 0.9rem;
            width: 56px;
        }

        .page-greeting {
            font-size: 2rem;
            margin-bottom: 0.2rem;
        }

        .page-meta { color: var(--text-muted); font-size: 0.875rem; }

        /* ── Link box ── */
        .link-box {
            align-items: center;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding: 0.85rem 1rem;
        }

        .link-url {
            color: var(--gold);
            flex: 1;
            font-size: 0.8rem;
            letter-spacing: 0.02em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copy-btn {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 7px;
            color: var(--text-muted);
            cursor: pointer;
            font-family: var(--font-body);
            font-size: 0.75rem;
            padding: 0.3rem 0.7rem;
            transition: color 0.2s, border-color 0.2s;
            white-space: nowrap;
        }

        .copy-btn:hover { border-color: var(--gold-dim); color: var(--gold); }

        /* ── Expiry ── */
        .expiry {
            align-items: center;
            color: var(--text-muted);
            display: flex;
            font-size: 0.8rem;
            gap: 0.4rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .expiry-dot {
            background: var(--win);
            border-radius: 50%;
            box-shadow: 0 0 6px var(--win);
            display: inline-block;
            height: 6px;
            width: 6px;
        }

        /* ── Action grid ── */
        .action-grid {
            display: grid;
            gap: 0.75rem;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 0.75rem;
        }

        .action-grid .btn-danger,
        .action-grid .btn-ghost {
            font-size: 0.82rem;
            padding: 0.75rem 1rem;
        }

        /* ── Big buttons ── */
        .lucky-btn {
            background: linear-gradient(135deg, var(--gold), #7a5520);
            border: none;
            border-radius: var(--radius);
            box-shadow: 0 4px 32px rgba(201,160,106,0.25);
            color: #0a0608;
            cursor: pointer;
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 400;
            letter-spacing: 0.01em;
            margin-bottom: 0.75rem;
            padding: 1.4rem;
            position: relative;
            text-align: center;
            transition: box-shadow 0.2s, transform 0.15s;
            width: 100%;
            overflow: hidden;
        }

        .lucky-btn:hover {
            box-shadow: 0 8px 48px rgba(201,160,106,0.4);
            transform: translateY(-1px);
        }

        .lucky-btn:active { transform: scale(0.98); }

        .lucky-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 60%);
        }

        .lucky-label { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.12em; opacity: 0.7; text-transform: uppercase; }

        .history-link {
            align-items: center;
            color: var(--text-muted);
            display: flex;
            font-size: 0.875rem;
            gap: 0.4rem;
            justify-content: center;
            padding: 0.75rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .history-link:hover { color: var(--gold); }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-inner">

            {{-- Header --}}
            <div class="page-header fade-up">
                <div class="avatar">{{ strtoupper(substr($userPage->user->username, 0, 1)) }}</div>
                <h1 class="display page-greeting">Hello, {{ $userPage->user->username }}</h1>
                <p class="page-meta">{{ $userPage->user->phone_number }}</p>
            </div>

            <div class="card card--glow fade-up fade-up-1">

                {{-- Link display --}}
                <span class="label">Your unique link</span>
                <div class="link-box" style="margin-top:0.5rem">
                    <span class="link-url" id="page-url">{{ url()->current() }}</span>
                    <button class="copy-btn" onclick="copyLink()">Copy</button>
                </div>

                {{-- Expiry --}}
                <div class="expiry">
                    <span class="expiry-dot"></span>
                    Active until {{ $userPage->expires_at->format('d M Y, H:i') }}
                </div>

                <hr class="divider">

                {{-- Manage --}}
                <span class="label">Manage link</span>
                <div class="action-grid" style="margin-top:0.75rem">
                    <form method="POST" action="{{ route('pages.regenerate', $userPage->route) }}">
                        @csrf
                        <button class="btn btn-ghost" type="submit" style="width:100%">
                            ↻ &nbsp;Regenerate
                        </button>
                    </form>

                    <form method="POST" action="{{ route('pages.deactivate', $userPage->route) }}"
                          onsubmit="return confirm('Deactivate this link? You will lose access.')">
                        @csrf
                        <button class="btn btn-danger" type="submit" style="width:100%">
                            ✕ &nbsp;Deactivate
                        </button>
                    </form>
                </div>

                <hr class="divider">

                {{-- Lucky button --}}
                <form method="POST" action="{{ route('rolls.lucky', $userPage->route) }}">
                    @csrf
                    <button class="lucky-btn" type="submit">
                        <div class="lucky-label">Tap to roll</div>
                        I'm Feeling Lucky 🎲
                    </button>
                </form>

                <a class="history-link" href="{{ route('rolls.history', $userPage->route) }}">
                    ◷ &nbsp;History
                </a>

            </div>

        </div>
    </div>

    <script>
        function copyLink() {
            const url = document.getElementById('page-url').textContent;
            navigator.clipboard.writeText(url).then(() => {
                const btn = document.querySelector('.copy-btn');
                btn.textContent = 'Copied!';
                btn.style.color = 'var(--win)';
                setTimeout(() => { btn.textContent = 'Copy'; btn.style.color = ''; }, 2000);
            });
        }
    </script>
@endsection
