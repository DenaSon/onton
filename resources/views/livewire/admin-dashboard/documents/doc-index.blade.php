<div class="flex flex-col md:flex-row max-w-7xl mx-auto gap-4 p-4">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-base-200 p-4 h-full md:sticky top-0 overflow-y-auto rounded-box shadow">
        <div class="text-lg  mb-2 font-semibold text-primary" >Docs</div>
        <ul class="menu rounded-box text-sm">
            <li><a href="#intro">Introduction</a></li>
            <li><a href="#usage">Getting Started</a></li>
            <li><a href="#corearea">Core Area</a></li>
            <li><a href="#user">User Manager</a></li>
            <li><a href="#VCs">VCs Manager</a></li>
            <li><a href="#payments">Payments Control</a></li>
            <li><a href="#monitoring">Monitoring</a></li>
            <li><a href="#FAQs">FAQs</a></li>
        </ul>
    </aside>



    <div class="flex-1 space-y-8">

        <x-header title="Introduction" class="text-primary"/>

        <x-collapse separator class="bg-base-100">
            <x-slot:heading>
                Key Features
            </x-slot:heading>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Byblos  offers tagging, content crawling, scheduling, automated email delivery, and advanced filtering—all accessible from a centralized dashboard.
                </p>
            </x-slot:content>
        </x-collapse>

        <x-collapse separator class="bg-base-100">
            <x-slot:heading>
                Tech Stack
            </x-slot:heading>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Built with Laravel, Livewire, TailwindCSS, and DaisyUI. It leverages Stripe via Cashier for billing and Advanced newsletter modules.
                </p>
            </x-slot:content>
        </x-collapse>

        <x-collapse separator class="bg-base-100">
            <x-slot:heading>
                Roles & Permissions
            </x-slot:heading>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    The platform supports multiple roles: Admins, Editors, and Subscribers, each with customizable access to content, settings, and user management.
                </p>
            </x-slot:content>
        </x-collapse>

        <x-collapse separator class="bg-base-100">
            <x-slot:heading>
                Why Byblos ?
            </x-slot:heading>
            <x-slot:content>
                <p class="text-sm leading-relaxed">
                    Byblos  simplifies newsletter curation through automation and personalization. It’s ideal for teams managing high-volume content with clarity.
                </p>
            </x-slot:content>
        </x-collapse>



        <div class="flex space-x-4">
            <button class="btn btn-sm bg-base-300">Prev</button>
            <button class="btn btn-sm btn-primary ">Next</button>
        </div>



    </div>
</div>
