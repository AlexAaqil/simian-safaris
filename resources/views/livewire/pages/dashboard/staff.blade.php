<div class="StaffDashboard">
    <section class="Statistics">
        <div class="container">
            <div class="stats">
                <div class="stat">
                    <p>{{ $count_tours }}</p>
                    <p>{{ Str::plural('Tour', $count_tours) }}</p>
                </div>

                <div class="stat">
                    <p>{{ $count_destinations }}</p>
                    <p>{{ Str::plural('Destination', $count_destinations) }}</p>
                </div>

                <div class="stat">
                    <p>{{ $count_bookings }}</p>
                    <p>{{ Str::plural('Booking', $count_bookings) }}</p>
                </div>

                <div class="stat">
                    <p>{{ $count_messages }}</p>
                    <p>{{ Str::plural('Message', $count_messages) }} & {{ $count_unread_messages }} Unread</p>
                </div>
            </div>
        </div>
    </section>

    <section class="Charts">
        <div class="container">
            <div class="chart orders">
                <h2>Bookings</h2>
                <canvas id="citiesChart"></canvas>
            </div>
        </div>
    </section>
</div>

@push("scripts")
    <script src="{{ asset('assets/js/chart.js') }}"></script>

    <script>
        let citiesChartInstance = null;

        function tryGetCanvas(id, retries = 10, delay = 100) {
            return new Promise((resolve, reject) => {
                function tryFind() {
                    const el = document.getElementById(id);
                    if (el) return resolve(el);
                    if (--retries <= 0) return reject(`Canvas ${id} not found`);
                    setTimeout(tryFind, delay);
                }
                tryFind();
            });
        }

        async function renderCitiesChart(labels, data) {
            try {
                const ctx = await tryGetCanvas('citiesChart');
                if (citiesChartInstance) citiesChartInstance.destroy();

                citiesChartInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Bookings',
                            data: data,
                            backgroundColor: [
                                '#3b82f6', '#6366f1', '#10b981', '#f59e0b',
                                '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });
            } catch (err) {
                console.warn(err);
            }
        }

        async function bootDashboardCharts() {
            await renderCitiesChart(@json($booking_labels), @json($booking_orders));
        }

        document.addEventListener('DOMContentLoaded', bootDashboardCharts);
        document.addEventListener('livewire:navigated', () => {
            setTimeout(bootDashboardCharts, 100); // slight delay is still useful
        });
    </script>
@endpush
