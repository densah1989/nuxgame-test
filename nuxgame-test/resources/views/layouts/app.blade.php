<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LuckyRoll')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #080810;
            --surface: #0f0f1a;
            --surface2: #16162a;
            --border: rgba(255, 255, 255, 0.07);
            --gold: #c9a06a;
            --gold-dim: #8a6c40;
            --gold-glow: rgba(201, 160, 106, 0.15);
            --text: #e2e2f0;
            --text-muted: #7a7a9a;
            --win: #4ade80;
            --win-glow: rgba(74, 222, 128, 0.15);
            --lose: #f87171;
            --lose-glow: rgba(248, 113, 113, 0.15);
            --radius: 16px;
            --font-display: 'Cormorant Garamond', Georgia, serif;
            --font-body: 'Outfit', sans-serif;
        }

        html, body {
            min-height: 100vh;
            background-color: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 20% 0%, rgba(201, 160, 106, 0.06) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 100%, rgba(80, 60, 180, 0.08) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        body > * {
            position: relative;
            z-index: 1;
        }

        /* ── Card ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem;
        }

        .card--glow {
            box-shadow: 0 0 60px rgba(201, 160, 106, 0.05), 0 24px 48px rgba(0, 0, 0, 0.4);
        }

        /* ── Typography ── */
        .display {
            font-family: var(--font-display);
            font-weight: 300;
            letter-spacing: 0.01em;
        }

        .label {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* ── Inputs ── */
        .field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .input {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: var(--font-body);
            font-size: 1rem;
            padding: 0.85rem 1.1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            width: 100%;
        }

        .input:focus {
            border-color: var(--gold-dim);
            box-shadow: 0 0 0 3px var(--gold-glow);
        }

        .input::placeholder {
            color: var(--text-muted);
        }

        /* ── Buttons ── */
        .btn {
            align-items: center;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            font-family: var(--font-body);
            font-size: 0.9rem;
            font-weight: 500;
            gap: 0.5rem;
            justify-content: center;
            letter-spacing: 0.03em;
            padding: 0.85rem 1.5rem;
            text-decoration: none;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            width: 100%;
        }

        .btn:active {
            transform: scale(0.97);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold), #a07840);
            color: #0a0608;
            box-shadow: 0 4px 24px rgba(201, 160, 106, 0.25);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 32px rgba(201, 160, 106, 0.4);
            opacity: 0.92;
        }

        .btn-ghost {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-ghost:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
        }

        .btn-danger {
            background: rgba(248, 113, 113, 0.1);
            border: 1px solid rgba(248, 113, 113, 0.2);
            color: var(--lose);
        }

        .btn-danger:hover {
            background: rgba(248, 113, 113, 0.18);
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        /* ── Badge ── */
        .badge {
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            padding: 0.25rem 0.65rem;
            text-transform: uppercase;
        }

        .badge-win {
            background: var(--win-glow);
            color: var(--win);
        }

        .badge-lose {
            background: var(--lose-glow);
            color: var(--lose);
        }

        /* ── Error list ── */
        .errors {
            background: rgba(248, 113, 113, 0.08);
            border: 1px solid rgba(248, 113, 113, 0.2);
            border-radius: 10px;
            color: var(--lose);
            font-size: 0.875rem;
            list-style: none;
            padding: 0.85rem 1.1rem;
        }

        .errors li + li {
            margin-top: 0.3rem;
        }

        /* ── Fade-in animation ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.5s ease both;
        }

        .fade-up-1 {
            animation-delay: 0.05s;
        }

        .fade-up-2 {
            animation-delay: 0.12s;
        }

        .fade-up-3 {
            animation-delay: 0.19s;
        }

        .fade-up-4 {
            animation-delay: 0.26s;
        }

        .fade-up-5 {
            animation-delay: 0.33s;
        }
    </style>
    @stack('styles')
</head>
<body>
@yield('content')
</body>
</html>
