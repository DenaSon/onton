<footer class="bg-base-300/95 text-base-content py-12 mt-10 border-t border-t-gray-300 border-base-300">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">


        <section aria-labelledby="footer-brand">
            <h2 id="footer-brand" class="font-semibold mb-2">About</h2>

            <p class="text-sm text-base-content/70">
                Make smarter startup moves with exclusive VC insights, curated and delivered straight to your inbox.
            </p>
        </section>


        <nav aria-labelledby="footer-navigation">
            <h3 id="footer-navigation" class="font-semibold text-base-content mb-3">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#features" class="hover:text-primary">Features</a></li>
                <li><a href="#pricing" class="hover:text-primary">Pricing</a></li>
                <li><a href="#about" class="hover:text-primary">About</a></li>
                <li><a href="#contact" class="hover:text-primary">Contact</a></li>
            </ul>
        </nav>


        <nav aria-labelledby="footer-resources">
            <h3 id="footer-resources" class="font-semibold text-base-content mb-3">Resources</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-primary">Blog</a></li>
                <li><a href="#" class="hover:text-primary">Help Center</a></li>
                <li><a href="#" class="hover:text-primary">Privacy Policy</a></li>
                <li><a href="#" class="hover:text-primary">Terms of Service</a></li>
            </ul>
        </nav>


        <section aria-labelledby="footer-subscribe">
            <h3 id="footer-subscribe" class="font-semibold text-base-content mb-3">Subscribe</h3>
            <p class="text-sm mb-3 text-base-content/60">Get curated updates</p>

            @livewire('home.subscribe-form')

        </section>

    </div>


    <div class="mt-12 border-t border-base-300 pt-6 text-sm text-center text-base-content/60">
        <small>
            © <span x-data="{ year: new Date().getFullYear() }" x-text="year"></span>
            {{ config('app.name') }}. All rights reserved.
        </small>
        <div class="mt-2 flex justify-center space-x-4" aria-label="Social media links">
            <a href="#" class="hover:text-primary">
                <x-icon name="o-share" class="w-4 h-4"/>
            </a>
            <a href="#" class="hover:text-primary">
                <x-icon name="o-share" class="w-4 h-4"/>
            </a>
            <a href="#" class="hover:text-primary">
                <x-icon name="o-share" class="w-4 h-4"/>
            </a>
        </div>
    </div>





</footer>
