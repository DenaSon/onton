<div class="col-span-1 bg-base-100 p-0 rounded-r-2xl h-[calc(100vh-8rem)] flex flex-col">

    @if($selected)


        <iframe
            class="w-full h-full border-0 rounded-r-2xl"
            sandbox="allow-same-origin allow-popups allow-forms"
            srcdoc="{{ $selected->body_html }}"
        ></iframe>

    @endif


</div>
