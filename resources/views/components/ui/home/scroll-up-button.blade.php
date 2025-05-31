<div x-data="{ show: false }" x-init="
    window.addEventListener('scroll', () => {
        show = window.scrollY > 300
    });
" class="fixed bottom-6 right-6 z-50">
    <button
        x-show="show"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="btn btn-circle btn-primary shadow-lg"
        x-transition
    >
        <x-icon name="o-arrow-up" />
    </button>
</div>
