<div>
    @if($open)
        <div class="modal modal-open sm:modal-middle" role="dialog">
            <div class="modal-box max-w-5xl p-0 bg-base-100">
                {{-- Header مودال --}}
                <div class="flex items-center justify-between px-5 py-3 border-b border-base-200">
                    <div>
                        <div class="flex items-center gap-2">
                            <x-icon name="o-rss" class="w-5 h-5 text-primary"/>
                            <h3 class="text-lg font-semibold tracking-tight text-base-content">
                                Medium posts
                            </h3>
                        </div>
                        @if(!empty($items))
                            <p class="text-[11px] text-base-content/60 mt-0.5">
                                Showing {{ count($items) }} recent articles from this VC’s Medium feed.
                            </p>
                        @endif
                    </div>

                    <button
                        wire:click="close"
                        type="button"
                        class="p-1.5 rounded-lg hover:bg-base-200 transition text-base-content/70 hover:text-base-content"
                    >
                        <x-icon name="o-x-mark" class="w-4 h-4"/>
                    </button>
                </div>

                {{-- Body مودال --}}
                <div class="px-5 py-4 max-h-[70vh] overflow-y-auto">
                    {{-- وضعیت لودینگ --}}
                    @if($loading)
                        <div class="flex items-center justify-center py-10">
                            <span class="loading loading-spinner loading-md"></span>
                        </div>

                        {{-- خطا --}}
                    @elseif($error)
                        <div class="alert alert-warning text-sm">
                            {{ $error }}
                        </div>

                        {{-- محتوا --}}
                    @elseif(!empty($items))
                        <div class="grid gap-4 md:grid-cols-5">
                            {{-- ستون چپ: لیست پست‌ها (sticky) --}}
                            <div
                                class="md:col-span-2 border border-base-300 rounded-xl bg-base-100 flex flex-col
                                       sticky top-0 self-start"
                            >
                                <div
                                    class="px-3 py-2 border-b border-base-200 text-[11px] text-base-content/60
                                           flex items-center justify-between"
                                >
                                    <span class="font-medium">
                                        Posts
                                    </span>
                                    <span>
                                        {{ count($items) }} items
                                    </span>
                                </div>

                                <div class="flex-1 overflow-y-auto">
                                    <ul class="space-y-1 p-2 pr-1">
                                        @foreach($items as $item)
                                            @php
                                                $index       = $loop->index;
                                                $isActive    = $activeIndex === $index;
                                                $title       = data_get($item, 'title', 'Untitled');
                                                $pubDateRaw  = data_get($item, 'pub_date');
                                                $author      = data_get($item, 'author');
                                                $categories  = data_get($item, 'categories', []);

                                                $pubDate = $pubDateRaw
                                                    ? \Carbon\Carbon::parse($pubDateRaw)->toDayDateTimeString()
                                                    : null;
                                            @endphp

                                            <li>
                                                <button
                                                    type="button"
                                                    wire:click="selectPost({{ $index }})"
                                                    class="w-full text-left px-3 py-2 text-xs rounded-lg border cursor-pointer
                                                        transition
                                                        {{ $isActive
                                                            ? 'border-primary/70 bg-primary/5 shadow-sm'
                                                            : 'border-base-300 hover:bg-base-200/60' }}
                                                        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/60 focus-visible:ring-offset-1 focus-visible:ring-offset-base-100"
                                                >
                                                    <div class="font-semibold line-clamp-2">
                                                        {{ $title }}
                                                    </div>

                                                    <div
                                                        class="mt-1 flex flex-wrap items-center gap-1 text-[10px] text-base-content/60">
                                                        @if($pubDate)
                                                            <span>{{ $pubDate }}</span>
                                                        @endif

                                                        @if($author)
                                                            <span class="inline-flex items-center gap-1">
                                                                <x-icon name="o-user" class="w-3 h-3"/>
                                                                {{ $author }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            {{-- ستون راست: Preview کامل پست انتخاب‌شده --}}
                            <div
                                class="md:col-span-3 border border-base-300 rounded-xl bg-base-100 flex flex-col overflow-hidden">
                                @php
                                    $post = $this->activeItem;
                                @endphp

                                @if($post)
                                    @php
                                        $title       = data_get($post, 'title', 'Untitled');
                                        $link        = data_get($post, 'link', '#');
                                        $pubDateRaw  = data_get($post, 'pub_date');
                                        $author      = data_get($post, 'author');
                                        $contentHtml = data_get($post, 'content', '');
                                        $categories  = data_get($post, 'categories', []);

                                        $plain = trim(
                                            preg_replace('/\s+/', ' ', strip_tags($contentHtml))
                                        );

                                        $readingTime = $plain
                                            ? ceil(str_word_count($plain) / 200)
                                            : null;

                                        $pubDate = $pubDateRaw
                                            ? \Carbon\Carbon::parse($pubDateRaw)->toDayDateTimeString()
                                            : null;
                                    @endphp

                                    {{-- Header پست (چسبان داخل ستون راست) --}}
                                    <div class="sticky top-0 z-10 bg-base-100 border-b border-base-200 px-4 pt-3 pb-3">
                                        <a
                                            href="{{ $link }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-sm font-semibold hover:text-primary"
                                        >
                                            {{ $title }}
                                        </a>

                                        <div
                                            class="mt-1 flex flex-wrap items-center gap-2 text-[11px] text-base-content/60">
                                            @if($pubDate)
                                                <span>{{ $pubDate }}</span>
                                            @endif

                                            @if($author)
                                                <span class="inline-flex items-center gap-1">
                                                    <x-icon name="o-user" class="w-3 h-3"/>
                                                    {{ $author }}
                                                </span>
                                            @endif

                                            @if($readingTime)
                                                <span class="inline-flex items-center gap-1">
                                                    <x-icon name="o-clock" class="w-3 h-3"/>
                                                    ~{{ $readingTime }} min read
                                                </span>
                                            @endif
                                        </div>

                                        @if(!empty($categories))
                                            <div class="mt-2 flex flex-wrap gap-1">
                                                @foreach($categories as $cat)
                                                    <span class="badge badge-ghost badge-xs">
                                                        {{ $cat }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif


                                    </div>

                                    {{-- محتوای کامل HTML --}}
                                    <div class="flex-1 overflow-y-auto px-4 pb-4 pt-2">
                                        <div class="prose prose-sm max-w-none">
                                            {!! $contentHtml !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="flex-1 flex items-center justify-center px-4 py-6">
                                        <p class="text-sm text-base-content/70">
                                            Select a post from the list to see its preview.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-base-content/70">
                            No Medium posts to display.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
