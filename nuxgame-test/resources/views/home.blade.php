@extends('layouts.app')

@section('title', 'LuckyRoll — Register')

@push('styles')
<style>
    .home-wrap {
        align-items: center;
        display: flex;
        justify-content: center;
        min-height: 100vh;
        padding: 2rem 1rem;
    }

    .home-inner {
        width: 100%;
        max-width: 420px;
    }

    .brand {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .brand-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--gold), #7a5520);
        border-radius: 14px;
        font-size: 1.6rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 32px rgba(201,160,106,0.3);
    }

    .brand-title {
        font-size: 2.4rem;
        color: var(--text);
        line-height: 1;
        margin-bottom: 0.4rem;
    }

    .brand-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .form-stack { display: flex; flex-direction: column; gap: 1.2rem; }

    .footer-note {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-top: 1.5rem;
        text-align: center;
    }

    .gold-text { color: var(--gold); }
</style>
@endpush

@section('content')
<div class="home-wrap">
    <div class="home-inner">

        <div class="brand fade-up">
            <div class="brand-icon">🎲</div>
            <h1 class="display brand-title">LuckyRoll</h1>
            <p class="brand-subtitle">Register to get your personal lucky page</p>
        </div>

        <div class="card card--glow fade-up fade-up-1">
            @if ($errors->any())
                <ul class="errors" style="margin-bottom:1.2rem">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-stack">
                    <div class="field fade-up fade-up-2">
                        <label class="label" for="username">Username</label>
                        <input
                            class="input"
                            id="username"
                            name="username"
                            type="text"
                            placeholder="e.g. john_doe"
                            value="{{ old('username') }}"
                            autocomplete="off"
                        >
                    </div>

                    <div class="field fade-up fade-up-3">
                        <label class="label" for="phonenumber">Phone number</label>
                        <input
                            class="input"
                            id="phonenumber"
                            name="phonenumber"
                            type="text"
                            placeholder="e.g. +1 234 567 8900"
                            value="{{ old('phonenumber') }}"
                            autocomplete="off"
                        >
                    </div>

                    <div class="fade-up fade-up-4" style="margin-top:0.5rem">
                        <button class="btn btn-primary" type="submit">
                            Register &amp; Get My Link →
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <p class="footer-note fade-up fade-up-5">
            Your link will be valid for <span class="gold-text">7 days</span>
        </p>

    </div>
</div>
@endsection
