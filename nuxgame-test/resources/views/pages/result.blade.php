@extends('layouts.app')

@section('title', 'LuckyRoll — Result')

@push('styles')
    <style>
        .result-wrap {
            align-items: center;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .result-inner {
            max-width: 420px;
            text-align: center;
            width: 100%;
        }

        /* ── Number display ── */
        .number-ring {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .number-ring.win-ring {
            background: radial-gradient(circle, var(--win-glow) 0%, transparent 70%);
            border: 2px solid rgba(74,222,128,0.3);
            box-shadow: 0 0 60px var(--win-glow);
        }

        .number-ring.lose-ring {
            background: radial-gradient(circle, var(--lose-glow) 0%, transparent 70%);
            border: 2px solid rgba(248,113,113,0.2);
            box-shadow: 0 0 60px var(--lose-glow);
        }

        .number-value {
            font-family: var(--font-display);
            font-size: 4rem;
            font-weight: 300;
            line-height: 1;
        }

        .win-ring  .number-value { color: var(--win); }
        .lose-ring .number-value { color: var(--lose); }

        /* ── Result label ── */
        .result-label {
            font-family: var(--font-display);
            font-size: 2.8rem;
            font-weight: 300;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .result-label.win  { color: var(--win); }
        .result-label.lose { color: var(--lose); }

        .result-desc { color: var(--text-muted); font-size: 0.875rem; margin-bottom: 2rem; }

        /* ── Prize card ── */
        .prize-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            padding: 1.2rem 1.5rem;
        }

        .prize-amount {
            color: var(--gold);
            font-family: var(--font-display);
            font-size: 2.4rem;
            font-weight: 400;
            line-height: 1;
        }

        .prize-zero { color: var(--text-muted); }

        /* ── Pop-in animation ── */
        @keyframes popIn {
            0%   { opacity: 0; transform: scale(0.6); }
            70%  { transform: scale(1.06); }
            100% { opacity: 1; transform: scale(1); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .pop-in  { animation: popIn  0.5s cubic-bezier(0.34,1.56,0.64,1) both; }
        .slide-1 { animation: slideUp 0.4s ease 0.3s both; }
        .slide-2 { animation: slideUp 0.4s ease 0.4s both; }
        .slide-3 { animation: slideUp 0.4s ease 0.5s both; }
        .slide-4 { animation: slideUp 0.4s ease 0.6s both; }
    </style>
@endpush

@section('content')
    <div class="result-wrap">
        <div class="result-inner">

            {{-- Number ring --}}
            <div class="pop-in">
                <div class="number-ring {{ $win ? 'win-ring' : 'lose-ring' }}">
                    <span class="number-value">{{ $number }}</span>
                </div>
            </div>

            {{-- Win / Lose label --}}
            <div class="result-label {{ $win ? 'win' : 'lose' }} slide-1">
                {{ $win ? 'Win' : 'Lose' }}
            </div>

            <p class="result-desc slide-2">
                {{ $win
                    ? 'Even number — congratulations!'
                    : 'Odd number — better luck next time.' }}
            </p>

            {{-- Prize --}}
            <div class="prize-card slide-3">
                <div class="label" style="margin-bottom:0.5rem">Prize amount</div>
                @if($win)
                    <div class="prize-amount">{{ number_format($prize, 2) }}</div>
                @else
                    <div class="prize-amount prize-zero">—</div>
                @endif
            </div>

            {{-- Back --}}
            <div class="slide-4">
                <a class="btn btn-ghost" href="{{ url()->previous() }}" style="display:inline-flex;width:auto;padding:0.75rem 2rem">
                    ← Back to my page
                </a>
            </div>

        </div>
    </div>
@endsection
