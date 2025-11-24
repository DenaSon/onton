@php
    /**
     * Normalize external URLs so they always open correctly.
     */
    function external_url(?string $url): ?string {
        if (! $url) return null;

        return preg_match('~^https?://~i', $url)
            ? $url
            : 'https://' . $url;
    }
@endphp

<div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

    <!-- Breadcrumb -->
    <div class="text-sm text-base-content/60">
        <a href="/feed" class="link">Feed</a>
        <span class="mx-1">/</span>
        <a href="/vc-directory" class="link">VC Directory</a>
        <span class="mx-1">/</span>
        <span>{{ $vc->name }}</span>
    </div>

    <!-- VC Header -->
    <div class="card bg-base-100/80 backdrop-blur shadow-lg border border-base-200 rounded-2xl p-8 space-y-4">

        <div class="flex items-start gap-6 flex-col lg:flex-row lg:items-center lg:justify-between">

            <!-- Left: Logo + Name -->
            <div class="flex items-start gap-5">
                <img src="{{ asset($vc->logo_url ?? 'static/img/no-vc-placeholder.png') }}"
                     class="w-20 h-20 rounded-2xl object-cover shadow-sm"
                     alt="VC Logo">

                <div class="space-y-2">
                    <div class="flex items-center gap-3 flex-wrap">
                        <h1 class="text-3xl font-bold leading-tight">{{ $vc->name }}</h1>
                        <span class="badge badge-outline badge-lg">{{ $vc->country }}</span>
                    </div>

                    <!-- Tags Below Name (Chip Bar) -->
                    @if($vc->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-2 text-xs mt-2">
                            @foreach($vc->tags as $tag)
                                <span class="badge badge-outline badge-sm rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="divider my-0"></div>

    <!-- Main Layout -->
    <div class="grid gap-8 lg:grid-cols-[1.8fr,2.2fr] items-start">

        <!-- LEFT SECTION -->
        <div class="space-y-6">

            <!-- Company Info -->
            <div class="card bg-base-100 shadow-sm border border-base-200 rounded-2xl p-6 space-y-4">
                <h2 class="text-lg font-semibold">Company Information</h2>

                <dl class="text-sm">

                    @if($vc->website)
                        <div class="flex items-center justify-between py-1.5 border-b border-base-200/60">
                            <dt class="text-xs uppercase tracking-wide text-base-content/50">Website</dt>
                            <dd class="text-right font-medium max-w-[240px] truncate">
                                <a href="{{ external_url($vc->website) }}" class="link link-hover" target="_blank">
                                    {{ external_url($vc->website) }}
                                </a>
                            </dd>
                        </div>
                    @endif

                    @if($vc->substack_url)
                        <div class="flex items-center justify-between py-1.5 border-b border-base-200/60">
                            <dt class="text-xs uppercase tracking-wide text-base-content/50">Substack</dt>
                            <dd class="text-right font-medium max-w-[240px] truncate">
                                <a href="{{ external_url($vc->substack_url) }}" class="link link-hover" target="_blank">
                                    {{ external_url($vc->substack_url) }}
                                </a>
                            </dd>
                        </div>
                    @endif

                    @if($vc->medium_url)
                        <div class="flex items-center justify-between py-1.5 border-b border-base-200/60">
                            <dt class="text-xs uppercase tracking-wide text-base-content/50">Medium</dt>
                            <dd class="text-right font-medium max-w-[240px] truncate">
                                <a href="{{ external_url($vc->medium_url) }}" class="link link-hover" target="_blank">
                                    {{ external_url($vc->medium_url) }}
                                </a>
                            </dd>
                        </div>
                    @endif

                    @if($vc->blog_url)
                        <div class="flex items-center justify-between py-1.5 border-b border-base-200/60">
                            <dt class="text-xs uppercase tracking-wide text-base-content/50">Blog</dt>
                            <dd class="text-right font-medium max-w-[240px] truncate">
                                <a href="{{ external_url($vc->blog_url) }}" class="link link-hover" target="_blank">
                                    {{ external_url($vc->blog_url) }}
                                </a>
                            </dd>
                        </div>
                    @endif

                    @if($vc->linkedin_url)
                        <div class="flex items-center justify-between py-1.5 border-b border-base-200/60">
                            <dt class="text-xs uppercase tracking-wide text-base-content/50">LinkedIn</dt>
                            <dd class="text-right font-medium max-w-[240px] truncate">
                                <a href="{{ external_url($vc->linkedin_url) }}" class="link link-hover" target="_blank">
                                    {{ external_url($vc->linkedin_url) }}
                                </a>
                            </dd>
                        </div>
                    @endif

                    @if(!empty($vc->official_x_accounts) || !empty($vc->staff_x_accounts))
                        <div class="flex items-center justify-between py-1.5">
                            <dt class="text-xs uppercase tracking-wide text-base-content/50">X Accounts</dt>
                            <dd class="text-right flex flex-wrap gap-1 justify-end">

                                @if(!empty($vc->official_x_accounts))
                                    @foreach($vc->official_x_accounts as $acc)
                                        @php $handle = ltrim($acc, '@'); @endphp
                                        <a href="https://twitter.com/{{ $handle }}"
                                           target="_blank"
                                           class="badge badge-outline badge-sm rounded-full hover:bg-base-200 transition">
                                            {{ '@'.$handle }}
                                        </a>
                                    @endforeach
                                @endif

                                @if(!empty($vc->staff_x_accounts))
                                    @foreach($vc->staff_x_accounts as $acc)
                                        @php $handle = ltrim($acc, '@'); @endphp
                                        <a href="https://twitter.com/{{ $handle }}"
                                           target="_blank"
                                           class="badge badge-outline badge-sm rounded-full hover:bg-base-200 transition">
                                            {{ '@'.$handle }}
                                        </a>
                                    @endforeach
                                @endif

                            </dd>
                        </div>
                    @endif

                </dl>
            </div>

        </div>

        <!-- RIGHT SECTION -->
        @include('livewire.user-dashboard.vc._partials.newsletters-trials')

    </div>
</div>
