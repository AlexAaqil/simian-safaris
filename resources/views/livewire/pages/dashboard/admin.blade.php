<div class="AdminDashboard">
    <section class="Statistics">
        <div class="container">
            <div class="stats">
                @if(auth()->user()->isSuperAdmin())
                    <div class="stat">
                        <p>{{ $count_super_admins }}</p>
                        <p>{{ Str::plural('Super Admin', $count_super_admins) }}</p>
                    </div>
                @endif

                <div class="stat">
                    <p>{{ $count_admins }}</p>
                    <p>{{ Str::plural('Admin', $count_admins) }}</p>
                </div>

                <div class="stat">
                    <p>{{ $count_users }}</p>
                    <p>{{ Str::plural('User', $count_users) }}</p>
                </div>

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

    <section class="Analytics">
        <div class="container">
            <div class="stats">
                <div class="stat">
                    <p>$ {{ number_format($gross_sales, 2) }}</p>
                    <p>Gross Sales (Quoted)</p>
                </div>

                <div class="stat">
                    <p>$ {{ number_format($net_sales, 2) }}</p>
                    <p>Net Sales (Received)</p>
                </div>

                <div class="stat">
                    <p class="{{ $revenue_delta < 0 ? 'text-red-600' : 'text-green-600' }}">$
                        {{ number_format($revenue_delta, 2) }}
                    </p>
                    <p>Gross Profit</p>
                </div>
            </div>
        </div>
    </section>

    <section class="Charts">
        <div class="container">
            <div class="chart sales">
                <h2>Sales</h2>
                <canvas id="salesChart"></canvas>
            </div>

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
        let salesChartInstance = null;
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

        async function renderSalesChart(data) {
            try {
                const ctx = await tryGetCanvas('salesChart');
                if (salesChartInstance) salesChartInstance.destroy();

                salesChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Amount',
                            data: data,
                            borderWidth: 1,
                            borderRadius: 2,
                            backgroundColor: '#3b82f6',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                    }
                });
            } catch (err) {
                console.warn(err);
            }
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
            await renderSalesChart(@json($sales_data));
            await renderCitiesChart(@json($booking_labels), @json($booking_orders));
        }

        document.addEventListener('DOMContentLoaded', bootDashboardCharts);
        document.addEventListener('livewire:navigated', () => {
            setTimeout(bootDashboardCharts, 100); // slight delay is still useful
        });
    </script>
@endpush
