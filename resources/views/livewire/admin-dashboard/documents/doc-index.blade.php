<div class="flex flex-col md:flex-row max-w-7xl mx-auto gap-4 p-4">



    <!-- Content Area -->

    <div class="flex-1 space-y-12 scroll-smooth">

        <!-- Introduction -->
        <section id="intro" class="space-y-4">
            <x-header title="Introduction" class="text-primary"/>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    What is Byblos?
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        <strong>Byblos</strong> is a smart content automation platform designed for curating and distributing venture-related newsletters.
                        It automatically scans designated inboxes, extracts newsletter content from trusted VC sources, and delivers personalized, filtered versions to subscribed users.
                        <br><br>
                        The system helps users stay updated with minimal noise, offering curated insights instead of overwhelming feeds. It's ideal for anyone who wants to keep track of startup, investment, or technology trends—without reading dozens of emails daily.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Key Functions
                </x-slot:heading>
                <x-slot:content>
                    <ul class="text-sm leading-relaxed list-disc pl-4 p-4">
                        <li>Email crawling and parsing from VC-focused inboxes</li>
                        <li>Tag-based content classification and filtering</li>
                        <li>Smart delivery based on user interests and subscriptions</li>
                        <li>Admin dashboard for full control over users, VCs, and newsletter pipelines</li>
                    </ul>
                </x-slot:content>
            </x-collapse>


        </section>

        <br/>

        <!-- Getting Started -->
        <section id="getting-started" class="space-y-4">
            <x-header title="Getting Started" class="text-primary"/>


            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Accessing the Admin Panel
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        The Byblos Admin Panel is accessible via
                        <code class="bg-base-300 px-1 rounded">byblos.digital/core</code>.
                        After successful authentication, super administrators are granted access to all key areas of the platform.
                        These include managing users, VC newsletter sources, email pipelines, tag filters, analytics, and overall system monitoring.
                        <br><br>
                        The panel is optimized for performance, clarity, and ease of use—providing quick access to high-level insights and operational controls.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Permissions & Access Levels
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        Access to the admin panel is restricted based on roles. Super Admins have full control over the platform, while other roles (e.g. Content Editors or Analysts) can be granted limited access depending on operational needs.
                        Role-based access ensures security, accountability, and workflow separation across teams.
                    </p>
                </x-slot:content>
            </x-collapse>
        </section>

        <br/>

        <!-- Dashboard -->
        <section id="dashboard" class="space-y-4">
            <x-header title="Dashboard" class="text-primary"/>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Overview & Key Metrics
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        The Byblos dashboard provides a real-time snapshot of the platform’s performance, usage, and system health.
                        It is designed to give administrators a quick overview of activity, user engagement, and financial trends.
                        <br><br>
                        Key metric cards display:
                    </p>
                    <ul class="list-disc pl-5 text-sm mt-2 p-2">
                        <li><strong>Total Users</strong> – including monthly growth insights</li>
                        <li><strong>Active Subscriptions</strong> – with week-by-week changes</li>
                        <li><strong>Newsletters Crawled</strong> – updated daily</li>
                        <li><strong>VC Firms</strong> – with weekly additions</li>
                    </ul>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Subscription & Billing Overview
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        This section summarizes subscription and revenue activity, helping admins track monetization performance.
                    </p>
                    <ul class="list-disc pl-5 text-sm mt-2 p-2">
                        <li><strong>Active Subscriptions</strong> – total number of paying users</li>
                        <li><strong>Estimated Revenue</strong> – based on current billing cycles</li>
                        <li><strong>Cancelled Subscriptions</strong> – to monitor churn rate</li>
                        <li><strong>Last Subscription</strong> – how recently a new user subscribed</li>
                    </ul>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Operational Insights
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        The dashboard also includes:
                    </p>
                    <ul class="list-disc pl-5 text-sm mt-2 p-2">
                        <li><strong>Registered Users Table</strong> –  list of all users</li>
                        <li><strong>Crawled Newsletters Table</strong> – shows processed content</li>
                        <li><strong>System Health</strong> – CPU, memory, and queue monitoring</li>
                        <li><strong>Latest Activity Logs</strong> – recent actions performed across the system</li>
                    </ul>
                    <p class="text-sm leading-relaxed mt-2">
                        These tools allow admins to detect anomalies, track trends, and ensure the system runs smoothly.
                    </p>
                </x-slot:content>
            </x-collapse>
        </section>

        <br/>
        <!-- User Manager -->
        <section id="user-manager" class="space-y-4">
            <x-header title="User Manager" class="text-primary"/>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Manage All Users
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        The User Manager section provides a centralized view of all registered users on the platform.
                        Admins can search, filter, and manage users with ease using the built-in search and action tools.
                        Each user entry includes personal details, subscription status, trial info, and more.
                    </p>
                    <ul class="list-disc pl-5 text-sm mt-2 p-2">
                        <li><strong>Search:</strong> Filter users by name or email</li>
                        <li><strong>Status:</strong> View if the user is active, suspended, or expired</li>
                        <li><strong>Registration Date:</strong> Track when the user signed up</li>
                        <li><strong>Trial Period:</strong> See trial status and end date</li>
                        <li><strong>Actions:</strong> Suspend or review user accounts</li>
                    </ul>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Subscription Details
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        For each user, detailed subscription data is shown—integrated directly with Stripe billing.
                        Admins can monitor the user's plan type, start date, payment history, trial usage, and current billing status.
                    </p>
                    <ul class="list-disc pl-5 text-sm mt-2 p-2">
                        <li><strong>Plan:</strong> Shows the Stripe plan ID associated with the user</li>
                        <li><strong>Start & End Dates:</strong> Subscription lifecycle tracking</li>
                        <li><strong>Trial:</strong> Indicates if the user is on a free trial</li>
                        <li><strong>Last Payment:</strong> Displays the most recent successful charge</li>
                        <li><strong>Stripe Status:</strong> e.g. Active, Trialing, Cancelled</li>
                    </ul>
                </x-slot:content>
            </x-collapse>
        </section>
        <br/>

        <!-- VCs Manager -->
        <section id="vcs-manager" class="space-y-4">
            <x-header title="VCs Manager" class="text-primary"/>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Manage VC Firms
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        The VCs Manager allows administrators to manage the list of supported Venture Capital firms.
                        Each VC entry includes organization details, newsletter stats, email whitelists, and category tags.
                        These records help the system identify and filter relevant newsletter sources during email crawling.
                    </p>
                    <ul class="list-disc pl-5 text-sm mt-2 p-2">
                        <li><strong>Search:</strong> Find firms by name or domain</li>
                        <li><strong>Status:</strong> Active/inactive toggle for controlling data flow</li>
                        <li><strong>Country & Website:</strong> Informational fields for VC profiling</li>
                        <li><strong>Created Date:</strong> When the VC was added to the system</li>
                        <li><strong>Actions:</strong> Edit or delete a VC entry</li>
                    </ul>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Tags & Whitelisted Emails
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        Each VC firm can be categorized using vertical and stage tags—e.g. <em>Blockchain</em>, <em>ClimateTech</em>, <em>Series A</em>. These tags enable targeted filtering and personalized delivery to users.
                        <br><br>
                        The whitelist email feature ensures that newsletters from known and trusted sources are captured during automated crawling. These addresses are manually defined per VC and matched against incoming emails.
                    </p>
                </x-slot:content>
            </x-collapse>
        </section>

        <br/>
        <!-- Payments Control -->
        <section id="monitoring" class="space-y-4">
            <x-header title="Monitoring" class="text-primary"/>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Job Execution Overview
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        This area displays recent background jobs that have been executed, including their completion status and processing times.
                        It allows administrators to verify that automated tasks are running smoothly and on schedule.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Queued and Failed Jobs
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        Here, admins can monitor jobs currently waiting in the queue as well as failed jobs that require attention.
                        This helps quickly identify bottlenecks or errors in asynchronous processes.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Database Query Monitoring
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        This section tracks database queries, highlighting slow or frequent queries to assist in optimizing system performance.
                        Monitoring query patterns helps maintain fast response times and efficient data access.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Request Performance Insights
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        Administrators gain insight into incoming HTTP requests, including request durations and response statuses.
                        This enables detection of slow endpoints or unusual traffic patterns impacting user experience.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Memory and System Resource Usage
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        Real-time monitoring of memory consumption and overall system load helps ensure the platform operates within healthy resource limits.
                        This aids in proactive scaling and prevents unexpected downtime.
                    </p>
                </x-slot:content>
            </x-collapse>

            <x-collapse separator class="bg-base-100">
                <x-slot:heading>
                    Visual Analytics & Activity Timelines
                </x-slot:heading>
                <x-slot:content>
                    <p class="text-sm leading-relaxed">
                        Interactive charts and detailed timelines provide historical context for job executions, errors, and system metrics.
                        These tools assist in root cause analysis and long-term performance tracking.
                    </p>
                </x-slot:content>
            </x-collapse>
        </section>





    </div>



</div>
