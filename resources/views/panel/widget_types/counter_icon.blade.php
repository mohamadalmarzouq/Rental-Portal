@php
    $symbols = [
        21 => 'total',
        22 => 'online',
        23 => 'offline',
        28 => 'kiosk',
        31 => 'net',
    ];
    $symbol = $symbols[(int) $widget->id] ?? null;
    if (!$symbol) {
        $title = strtolower($widget->title);
        if (strpos($title, 'online') !== false) {
            $symbol = 'online';
        } elseif (strpos($title, 'offline') !== false) {
            $symbol = 'offline';
        } elseif (strpos($title, 'kiosk') !== false) {
            $symbol = 'kiosk';
        } elseif (strpos($title, 'net') !== false) {
            $symbol = 'net';
        } else {
            $symbol = 'total';
        }
    }
@endphp
@if ($symbol === 'online')
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 18.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-4.24-3.76a6 6 0 0 1 8.48 0l-1.7 1.7a3.6 3.6 0 0 0-5.08 0l-1.7-1.7zm-3.54-3.53a11 11 0 0 1 15.56 0l-1.7 1.7a8.6 8.6 0 0 0-12.16 0l-1.7-1.7zM2 7.7A15.5 15.5 0 0 1 22 7.7l-1.7 1.7a13.1 13.1 0 0 0-16.6 0L2 7.7z"/></svg>
@elseif ($symbol === 'offline')
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11zM7 8a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2H7zm10 7.2c0-1.77-1.57-3.2-3.5-3.2S10 13.43 10 15.2 11.57 18.4 13.5 18.4 17 16.97 17 15.2zm-3.5-1.45c.83 0 1.5.54 1.5 1.2s-.67 1.2-1.5 1.2-1.5-.54-1.5-1.2.67-1.2 1.5-1.2z"/></svg>
@elseif ($symbol === 'kiosk')
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 2.75A1.75 1.75 0 0 1 7.75 1h8.5A1.75 1.75 0 0 1 18 2.75V12H6V2.75zM8 3.5v2h8v-2H8zM5 13.5h14l.7 6.3A1.75 1.75 0 0 1 18 21.5H6a1.75 1.75 0 0 1-1.7-1.7L5 13.5zm4.25 2.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5z"/></svg>
@elseif ($symbol === 'net')
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.25 4.5a1.25 1.25 0 0 1 1.25 1.25v5a1.25 1.25 0 1 1-2.5 0V8.52l-6.22 6.22a1.25 1.25 0 0 1-1.77 0L8.5 12.23l-5.36 4.47a1.25 1.25 0 1 1-1.6-1.92l6.16-5.14a1.25 1.25 0 0 1 1.61.04l2.51 2.51 5.34-5.34h-2.16a1.25 1.25 0 1 1 0-2.5h5.25zM3.5 19.25h17a1.25 1.25 0 1 1 0 2.5h-17a1.25 1.25 0 1 1 0-2.5z"/></svg>
@else
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.5a3 3 0 0 1 2.9 2.25H16.5A2.5 2.5 0 0 1 19 7.25v11A2.5 2.5 0 0 1 16.5 20.75h-9A2.5 2.5 0 0 1 5 18.25v-11A2.5 2.5 0 0 1 7.5 4.75h1.6A3 3 0 0 1 12 2.5zm0 2a1 1 0 0 0-.9.55 1 1 0 0 0-.1.45h2a1 1 0 0 0-.1-.45A1 1 0 0 0 12 4.5zM8 9.25a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H8zm0 4a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2H8z"/></svg>
@endif
