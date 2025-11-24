<div class="max-w-6xl mx-auto px-4 py-8 space-y-6">

    <!-- Breadcrumb -->
    <div class="text-sm text-base-content/60">
        <a href="/feed" class="link">Feed</a>
        <span class="mx-1">/</span>
        <a href="/vc-directory" class="link">VC Directory</a>
        <span class="mx-1">/</span>
        <span>VC Name</span>
    </div>

    <!-- VC Header -->
    <div class="card bg-base-100 shadow-md p-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <!-- Left: Logo + Name + Description -->
        <div class="flex items-start gap-4">
            <img src="{{ asset($vc->logo) }}"/>
            class="w-16 h-16 rounded-xl object-cover"
            alt="VC Logo">

            <div class="space-y-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <h1 class="text-2xl font-bold">VC Firm Name</h1>
                    <span class="badge badge-outline">Country</span>
                </div>
                <p class="text-sm text-base-content/70 max-w-xl">
                    Short description of the VC firm. This text explains what the company does
                    and what kind of startups they invest in.
                </p>
            </div>
        </div>

        <!-- Right: Links (horizontal) -->
        <div class="flex flex-wrap gap-2 justify-start lg:justify-end">
            <button class="btn btn-sm btn-ghost">Website</button>
            <button class="btn btn-sm btn-ghost">Substack</button>
            <button class="btn btn-sm btn-ghost">Medium</button>
            <button class="btn btn-sm btn-ghost">Blog</button>
            <button class="btn btn-sm btn-ghost">LinkedIn</button>
            <button class="btn btn-sm btn-ghost">X</button>
        </div>

    </div>

    <!-- Main Layout -->
    <div class="grid gap-6 lg:grid-cols-[2fr,3fr]">

        <!-- Left: Company Info -->
        <div class="space-y-4">

            <!-- Company info block -->
            <div class="card bg-base-100 shadow-sm p-4 space-y-3">
                <h2 class="text-lg font-semibold">Company information</h2>

                <dl class="text-sm space-y-2">
                    <div class="flex justify-between gap-4">
                        <dt class="text-base-content/60">Website</dt>
                        <dd class="text-right">
                            <a href="#" class="link link-hover">https://vcwebsite.com</a>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-base-content/60">Substack</dt>
                        <dd class="text-right">
                            <a href="#" class="link link-hover">substack.com/@vcname</a>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-base-content/60">Medium</dt>
                        <dd class="text-right">
                            <a href="#" class="link link-hover">medium.com/@vcname</a>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-base-content/60">LinkedIn</dt>
                        <dd class="text-right">
                            <a href="#" class="link link-hover">linkedin.com/company/vcname</a>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Tags -->
            <div class="card bg-base-100 shadow-sm p-4 space-y-3">
                <h3 class="text-sm font-semibold">Tags</h3>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="badge badge-outline">Fintech</span>
                    <span class="badge badge-outline">Seed</span>
                    <span class="badge badge-outline">Europe</span>
                </div>
            </div>

            <!-- Portfolio preview (optional) -->
            <div class="card bg-base-100 shadow-sm p-4 space-y-3">
                <h3 class="text-sm font-semibold">Selected portfolio</h3>
                <ul class="text-sm space-y-1 list-disc list-inside">
                    <li>Startup One</li>
                    <li>Startup Two</li>
                    <li>Startup Three</li>
                </ul>
            </div>

        </div>

        <!-- Right: Latest Content -->
        <div class="space-y-4">

            <div class="card bg-base-100 shadow-sm p-4">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-lg font-semibold">Latest content</h2>
                        <p class="text-xs text-base-content/60">
                            Newsletter titles related to this VC.
                            Full content requires a trial or subscription.
                        </p>
                    </div>
                    <span class="badge badge-outline text-xs">Public view</span>
                </div>

                <!-- Table-style list -->
                <div class="overflow-x-auto">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Source</th>
                            <th class="text-right">Access</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="opacity-80">
                            <td>Q4 Market Update: AI & Infra</td>
                            <td>2025-11-10</td>
                            <td>Substack</td>
                            <td class="text-right">
                                <span class="badge badge-outline badge-sm">Locked</span>
                            </td>
                        </tr>
                        <tr class="opacity-80">
                            <td>Why we invested in ExampleCorp</td>
                            <td>2025-11-05</td>
                            <td>Email</td>
                            <td class="text-right">
                                <span class="badge badge-outline badge-sm">Locked</span>
                            </td>
                        </tr>
                        <tr class="opacity-80">
                            <td>State of European Seed 2025</td>
                            <td>2025-10-30</td>
                            <td>Medium</td>
                            <td class="text-right">
                                <span class="badge badge-outline badge-sm">Locked</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- CTA -->
                <div class="mt-4 flex items-center justify-between gap-3">
                    <p class="text-xs text-base-content/60">
                        Start a free trial to read full newsletters from this VC.
                    </p>
                    <button class="btn btn-primary btn-sm">
                        Start trial
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>
