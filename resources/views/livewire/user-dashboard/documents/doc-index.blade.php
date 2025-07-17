<div class="flex flex-col md:flex-row max-w-7xl mx-auto gap-4 p-4">


    <div class="flex-1 space-y-12 scroll-smooth">

        <!-- Introduction -->
        <section id="intro" class="space-y-4">
            <x-header separator progress-indicator subtitle="Your guide to mastering Byblos features" title="Help Center" class="" icon="o-question-mark-circle"/>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    What is Byblos?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed p-2">
                        <strong>Byblos</strong> is a smart content automation platform designed for curating and
                        distributing venture-related newsletters.
                        It automatically scans designated inboxes, extracts newsletter content from trusted VC sources,
                        and delivers personalized, filtered versions to subscribed users.
                        <br><br>
                        The system helps users stay updated with minimal noise, offering curated insights instead of
                        overwhelming feeds. It's ideal for anyone who wants to keep track of startup, investment, or
                        technology trends—without reading dozens of emails daily.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    How to connect your inbox?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed p-2">
                        Once you sign up and verify your email address, Byblos starts working with your registered inbox.
                        <br><br>
                        If you activate the <strong>Trial Plan</strong>, the system will automatically detect and forward newsletters from VC sources you follow directly into your curated feed.
                        <br><br>
                        You can also manually import newsletters by clicking the <strong>Inbox</strong> button inside your dashboard. However, to enjoy full automation—including real-time delivery of followed VC newsletters—your trial plan must be active.
                    </p>
                </x-slot:content>
            </x-collapse>


            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    How to view your curated feed?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed p-2">
                        Your curated feed displays the latest newsletters from VC firms you follow — in addition to the copies sent to your inbox.
                        <br><br>
                        To activate this feature, go to the <strong>VC Directory</strong> page and follow your favorite VC firms. Once followed, their newsletters will automatically appear in your personalized feed.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    How to access the VC Directory?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed p-2">
                        To access the VC Directory, visit:<br>
                        <a  href="https://byblos.digital/panel/vc/directory" class="text-primary underline" target="_blank">
                           VC Directory
                        </a>
                        <br><br>
                        You’ll see a list of the most recently added VC firms on Byblos. At the top of the page, there's a <strong>Search and Filter</strong> menu where you can:
                    </p>
                    <ul class="list-disc text-sm p-4 pt-0 leading-relaxed">
                        <li>Search for a VC firm by name</li>
                        <li>Filter VC firms based on <strong>Vertical</strong> and <strong>Stage</strong> tags</li>
                    </ul>
                    <p class="text-sm px-4 pt-0">
                        Once you select a tag, all matching VC firms will be instantly displayed.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    How to manage your subscription plan?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed p-2">
                        To manage your current plan, go to:<br>
                        <a href="{{ route('panel.payment.management') }}" class="text-primary underline" target="_blank">
                            Subscription Settings
                        </a>
                        <br><br>
                        On this page, you can see the details of your current plan, including:
                    </p>
                    <ul class="list-disc text-sm p-4 pt-0 leading-relaxed">
                        <li><strong>Plan price</strong> (e.g., $9.99/month)</li>
                        <li><strong>Plan status</strong> (e.g., trialing or active)</li>
                        <li><strong>Trial end date</strong></li>
                        <li><strong>Next billing date</strong></li>
                    </ul>
                    <p class="text-sm px-4 pt-0">
                        You can cancel your subscription at any time using the cancellation option.
                    </p>
                    <p class="text-sm px-4 pt-2">
                        Below this section, you'll also find your <strong>Billing History</strong> listing all previous transactions.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    How to set up newsletter delivery settings?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed p-2">
                        In the <strong>
                            <a href="{{ route('panel.setting.delivery') }}" target="_blank">Delivery Settings</a>
                        </strong> section, you can easily configure how often you want to receive curated newsletters.
                    </p>
                    <ul class="list-disc text-sm p-4 pt-0 leading-relaxed">
                        <li>Select your preferred <strong>Delivery Frequency</strong>: Daily or Weekly.</li>
                        <li>Changes can be made instantly with just two clicks.</li>
                    </ul>
                    <p class="text-sm px-4 pt-0">
                        Adjusting this setting helps you control the flow of content based on your personal reading habits.
                    </p>
                </x-slot:content>
            </x-collapse>





        </section>

        <br/>


    </div>


</div>
