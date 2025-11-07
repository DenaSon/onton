
    @if($selected)


        <iframe
            class="w-full h-full border-0 rounded-r-2xl"
            sandbox="allow-same-origin allow-popups"
            referrerpolicy="no-referrer"
            srcdoc="{{ $selected->body_html }}"
        ></iframe>

    @endif


