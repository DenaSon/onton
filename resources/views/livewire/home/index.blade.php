<div>

    @push('meta')
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                'name' => 'Byblos',
                'url' => 'https://byblos.digital',
                'description' => 'Follow top VC firms and get curated newsletters in your inbox with Byblos.',
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'Byblos',
                    'url' => 'https://byblos.digital',
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => 'https://byblos.digital/static/img/byblos-logo.png',
                    ]
                ]
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>

        <meta name="description"
              content="{{ 'Byblos | Follow top VC firms and get curated newsletters in your inbox' }}">
        <meta property="og:title" content="{{ $title ?? 'Byblos' }}">
        <meta property="og:description"
              content="Byblos | Follow top VC firms and get curated newsletters in your inbox">
        <meta property="og:image" content="{{ asset('static/img/byblos-hero.webp') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta name="twitter:card" content="summary_large_image">




    @endpush


    <x-ui.home.hero/>

    <x-ui.home.features/>

    <x-ui.home.timeline/>

    <x-ui.home.pricing/>


        @include('components.ui.home.scroll-up-button')


</div>
