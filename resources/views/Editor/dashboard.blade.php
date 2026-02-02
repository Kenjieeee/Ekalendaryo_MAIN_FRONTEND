<x-editorLayout>
    <!-- Dashboard Container -->
    <div class="dashboard_container">

        <!-- Welcome Card -->
        <section class="dashboard_welcome_card">
            <div>
                <h2>Welcome back, {{ Auth::user()->name }}!</h2>
                <p>
                    @if (Auth::user()->department === 'OFFICES')
                        {{ Auth::user()->office_name }}
                    @else
                        {{ Auth::user()->title }}
                    @endif Dashboard
                </p>
                <p class="dashboard_school_year">Current School Year: {{ $currentSchoolYearName }}</p>
            </div>
        </section>

        <!-- Upcoming Events -->
        <section class="dashboard_upcoming_card">
            <h3 class="dashboard_upcoming_title">Upcoming Events</h3>
            <p>For the next 30 days</p>

            @if ($events->isEmpty())
                <p>No upcoming events found.</p>
            @else
                <div class="dashboard_events_grid">
                    @foreach ($events as $event)
                        <div class="dashboard_event_card">
                            <div class="dashboard_event_title">{{ $event->title }}</div>

                            <div class="dashboard_event_details">
                                📅 {{ \Carbon\Carbon::parse($event->date)->format('n/j/Y') }}
                                &nbsp;&nbsp; 🕓 {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                &nbsp;&nbsp; 📍 {{ $event->location }}
                            </div>

                            <div class="dashboard_event_details">
                                👤
                                @if (is_array($event->target_year_levels) && count($event->target_year_levels) > 0)
                                    @foreach ($event->target_year_levels as $yearLevel)
                                        {{ $yearLevel . ',' }}
                                    @endforeach
                                @else
                                    {{ $event->target_users }}
                                @endif
                            </div>

                            <div class="dashboard_event_details">
                                {{ $event->description ?? 'No description provided.' }}
                            </div>
                            <div class="dashboard_event_details">SY.{{ $event->school_year }}</div>

                            <div class="dashboard_event_details">
                                👥 {{ $event->attendees()->count() }} attending
                            </div>

                            <div class="dashboard_event_tags">
                                <span class="dashboard_tag dashboard_tag_admin">
                                    @if ($event->department === 'OFFICES')
                                        {{ $event->user->office_name ?? 'Office' }}
                                    @else
                                        {{ $event->department }}
                                    @endif
                                </span>

                                <span
                                    class="dashboard_tag 
                                    @if ($event->computed_status === 'ongoing') dashboard_tag_ongoing
                                    @elseif($event->computed_status === 'upcoming') dashboard_tag_upcoming
                                    @elseif($event->computed_status === 'cancelled') dashboard_tag_cancelled
                                    @elseif($event->computed_status === 'completed') dashboard_tag_completed @endif
                                ">
                                    {{ ucfirst($event->computed_status) }}
                                </span>
                            </div>

                            <button class="dashboard_view_btn" data-id="{{ $event->id }}"
                                data-details="{{ e($event->more_details ?? 'No additional details.') }}">
                                👁️ View Details
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

    <!-- Event Details Modal -->
    <div id="dashboardDetailsModalOverlay">
        <div class="dashboard_modal_content">
            <h2>Event Details</h2>
            <textarea id="dashboardDetailsTextarea" readonly></textarea>
            <div style="text-align: right; margin-top: 10px;">
                <button id="dashboardDetailsCloseBtn">Close</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // --- Modal Functionality ---
            const detailsModal = document.getElementById("dashboardDetailsModalOverlay");
            const detailsTextarea = document.getElementById("dashboardDetailsTextarea");
            const detailsCloseBtn = document.getElementById("dashboardDetailsCloseBtn");

            document.addEventListener("click", function (e) {
                const btn = e.target.closest(".dashboard_view_btn");
                if (!btn) return;

                let raw = btn.dataset.details || "No additional details.";
                raw = raw.replace(/\\n/g, "\n");
                detailsTextarea.value = raw.trim();
                detailsModal.style.display = "flex";
                detailsTextarea.focus();
            });

            detailsCloseBtn.addEventListener("click", () => {
                detailsModal.style.display = "none";
            });

            window.addEventListener("click", (e) => {
                if (e.target === detailsModal) {
                    detailsModal.style.display = "none";
                }
            });

            window.addEventListener("keydown", (e) => {
                if (e.key === "Escape" && detailsModal.style.display === "flex") {
                    detailsModal.style.display = "none";
                }
            });
        });
    </script>
</x-editorLayout>
