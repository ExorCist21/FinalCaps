<title>Reports</title>
<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Admin Reports</h1>
            <p class="text-lg text-gray-600">Overview of your platform's key metrics and performance.</p>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Appointments Overview</h2>
                <canvas id="appointmentsChart" height="200"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Payment Reports</h2>
                <canvas id="paymentsChart" height="200"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Monthly Revenue (₱)</h2>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Total Revenue (₱) </h2>
                <canvas id="revenueChartT"></canvas>
            </div>
        </div>

        <!-- Feedback Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-6 rounded-lg text-white flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">Therapist Feedbacks</h2>
                    <p class="text-3xl font-bold">{{ $feedbacks }}</p>
                </div>
                <a href="{{ route('admin.therapistFeedbacks') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">View Feedbacks</a>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-400 p-6 rounded-lg text-white flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">System Feedbacks</h2>
                    <p class="text-3xl font-bold">{{ $systemfeedbacks }}</p>
                </div>
                <a href="{{ route('admin.systemFeedbacks') }}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded">View Feedbacks</a>
            </div>
        </div>

        <!-- Top Therapists -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Therapists</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($topTherapists as $therapist)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-transform transform hover:scale-105">
                    <h3 class="text-lg font-semibold text-gray-800">Therapist ID: {{ $therapist->therapistID }}</h3>
                    <h3 class="text-lg font-semibold text-gray-700">Name: {{ $therapist->therapist->first_name }} {{ $therapist->therapist->last_name }}</h3>
                    <p class="text-sm text-gray-600 mt-2">Total Appointments:</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $therapist->total }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Appointments Chart
            new Chart(document.getElementById('appointmentsChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Total', 'Completed', 'Pending'],
                    datasets: [{
                        label: 'Appointments',
                        data: [{{ $totalAppointments }}, {{ $completedAppointments }}, {{ $pendingAppointments }}],
                        backgroundColor: ['#6366F1', '#10B981', '#F87171']
                    }]
                }
            });

            // Payments Chart
            new Chart(document.getElementById('paymentsChart'), {
                type: 'bar',
                data: {
                    labels: ['Pending Payments', 'Completed'],
                    datasets: [{
                        label: 'Payments',
                        data: [{{ $pendingPayments }}, {{ $completedPayments }}],
                        backgroundColor: ['#EC4899', '#4F46E5']
                    }]
                }
            });

            // Revenue Chart
            new Chart(document.getElementById('revenueChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
                    datasets: [{
                        label: 'Revenue in ₱',
                        data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
                        backgroundColor: 'rgba(34,197,94,0.6)'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(document.getElementById('revenueChartT'), {
                type: 'bar',
                data: {
                    labels: ['Revenue'],
                    datasets: [{
                        label: '₱',
                        data: [{{ $totalRevenue }}],
                        backgroundColor: ['rgba(34,197,94,0.6)']
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
