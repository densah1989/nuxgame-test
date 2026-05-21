@extends('layouts.app')

@section('title', 'LuckyRoll — History')

@push('styles')
    <style>
        .history-wrap {
            display: flex;
            justify-content: center;
            min-height: 100vh;
            padding: 3rem 1rem;
        }

        .history-inner {
            max-width: 480px;
            width: 100%;
        }

        .history-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .history-title {
            font-size: 2.2rem;
            margin-bottom: 0.25rem;
        }

        .history-sub { color: var(--text-muted); font-size: 0.875rem; }

        /* ── Roll item ── */
        .roll-list { display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem; }

        .roll-item {
            align-items: center;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex;
            gap: 1rem;
            padding: 1.1rem 1.25rem;
            transition: border-color 0.2s;
        }

        .roll-item:hover { border-color: rgba(255,255,255,0.12); }

        .roll-number-badge {
            align-items: center;
            border-radius: 10px;
            display: flex;
            flex-shrink: 0;
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 400;
            height: 52px;
            justify-content: center;
            width: 52px;
        }

        .roll-number-badge.win  { background: var(--win-glow);  color: var(--win); }
        .roll-number-badge.lose { background: var(--lose-glow); color: var(--lose); }

        .roll-info { flex: 1; }

        .roll-result-row {
            align-items: center;
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.2rem;
        }

        .roll-prize {
            color: var(--gold);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .roll-prize-zero { color: var(--text-muted); }

        .roll-date {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .roll-index {
            color: var(--text-muted);
            flex-shrink: 0;
            font-size: 0.75rem;
        }

        /* ── Empty state ── */
        .empty {
            border: 1px dashed var(--border);
            border-radius: 12px;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            padding: 3rem 2rem;
            text-align: center;
        }

        .empty-icon { font-size: 2rem; margin-bottom: 0.75rem; }
    </style>
@endpush

@section('content')
    <div class="history-wrap">
        <div class="history-inner">

            <div class="history-header fade-up">
                <h1 class="display history-title">Last Results</h1>
                <p class="history-sub">Up to 3 most recent rolls</p>
            </div>

            @if($rolls->isEmpty())
                <div class="empty fade-up fade-up-1">
                    <div class="empty-icon">🎲</div>
                    <p>No rolls yet. Go hit that lucky button!</p>
                </div>
            @else
                <div class="roll-list">
                    @foreach($rolls as $i => $roll)
                        <div class="roll-item fade-up" style="animation-delay: {{ $i * 0.08 }}s">

                            <div class="roll-number-badge {{ $roll['win'] ? 'win' : 'lose' }}">
                                {{ $roll['number'] }}
                            </div>

                            <div class="roll-info">
                                <div class="roll-result-row">
                                <span class="badge {{ $roll['win'] ? 'badge-win' : 'badge-lose' }}">
                                    {{ $roll['win'] ? 'Win' : 'Lose' }}
                                </span>
                                    @if($roll['win'])
                                        <span class="roll-prize">+{{ number_format($roll['prize'], 2) }}</span>
                                    @else
                                        <span class="roll-prize-zero">No prize</span>
                                    @endif
                                </div>
                                <div class="roll-date">{{ $roll['created_at']->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="roll-index">#{{ $i + 1 }}</div>

                        </div>
                    @endforeach
                </div>
            @endif

            <div class="fade-up" style="text-align:center">
                <a class="btn btn-ghost" href="{{ url()->previous() }}" style="display:inline-flex;width:auto;padding:0.75rem 2rem">
                    ← Back to my page
                </a>
            </div>

        </div>
    </div>
@endsection
