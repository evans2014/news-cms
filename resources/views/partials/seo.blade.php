<title>{{ $title ?? config('app.name') }}</title>
<meta name="description" content="{{ $description ?? 'Актуално, бързо, точно.' }}">

{{-- Open Graph / Facebook / Viber / Telegram --}}
<meta property="og:title" content="{{ $title ?? config('app.name') }}">
<meta property="og:description" content="{{ $description ?? 'Актуално, бързо, точно.' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $description ?? 'Новини' }}">
<meta name="twitter:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">

{{-- Canonical --}}
<link rel="canonical" href="{{ request()->url() }}">