<title>My Reports</title>
<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-8">Therapist Reports</h1>

        <!-- Summary Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Appointments Summary</h2>
                <canvas id="appointmentsChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Total Revenue (₱)</h2>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Patient Progress Summary</h2>
                <canvas id="progressChart"></canvas>
            </div>
        </div>

        <!-- Patient Progress Details (Optional Table/List for Reference) -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Patient Progress Details</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($patientProgress as $progress)
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Appointment #{{ $progress->appointment_id }}</h3>
                    <p class="text-sm text-gray-600"><strong>Mental Condition:</strong> {{ $progress->mental_condition }}</p>
                    <p class="text-sm text-gray-600"><strong>Mood:</strong> {{ $progress->mood }}</p>
                    <p class="text-sm text-gray-600"><strong>Remarks:</strong> {{ $progress->remarks }}</p>
                    <p class="text-sm font-medium mt-2
                        {{ $progress->status == 'Completed' ? 'text-green-600' : '' }}
                        {{ $progress->status == 'Pending' ? 'text-yellow-600' : '' }}
                        {{ $progress->status == 'Cancelled' ? 'text-red-600' : '' }}">
                        <strong>Status:</strong> {{ $progress->status }}
                    </p>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-500">
                    <p>No patient progress data available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Config -->
    <script>
        const appointmentsChart = new Chart(document.getElementById('appointmentsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [{{ $completedAppointments }}, {{ $appointments - $completedAppointments }}],
                    backgroundColor: ['#10B981', '#FBBF24'],
                }]
            }
        });

        const revenueChart = new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: ['Total Revenue'],
                datasets: [{
                    label: '₱',
                    data: [{{ $totalRevenue }}],
                    backgroundColor: '#3B82F6'
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const progressStatusData = @json($patientProgress->groupBy('status')->map->count());

        const progressChart = new Chart(document.getElementById('progressChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(progressStatusData),
                datasets: [{
                    data: Object.values(progressStatusData),
                    backgroundColor: ['#34D399', '#F87171', '#FBBF24']
                }]
            }
        });
    </script>
</x-app-layout>
