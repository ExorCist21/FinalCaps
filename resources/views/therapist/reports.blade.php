<title>My Reports</title>
<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-8">Therapist Reports</h1>


        <!-- Summary Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all">
                <h2 class="text-lg font-semibold">Total Appointments</h2>
                <p class="text-4xl font-extrabold">{{ $appointments }}</p>
            </div>
            <div class="bg-gradient-to-r from-green-400 to-teal-500 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all">
                <h2 class="text-lg font-semibold">Completed Appointments</h2>
                <p class="text-4xl font-extrabold">{{ $completedAppointments }}</p>
            </div>
        </div>

        <!-- Patient Progress Section -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Patient Progress</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($patientProgress as $progress)
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-all">
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Appointment ID: {{ $progress->appointment_id }}</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-md font-semibold text-gray-700">Mental Condition:</h4>
                            <p class="text-gray-600 text-sm">{{ $progress->mental_condition }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-semibold text-gray-700">Mood:</h4>
                            <p class="text-gray-600 text-sm">{{ $progress->mood }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-semibold text-gray-700">Remarks:</h4>
                            <p class="text-gray-600 text-sm">{{ $progress->remarks }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-semibold text-gray-700">Status:</h4>
                            <p class="text-sm font-medium 
                                {{ $progress->status == 'Completed' ? 'text-green-600' : '' }}
                                {{ $progress->status == 'Pending' ? 'text-yellow-600' : '' }}
                                {{ $progress->status == 'Cancelled' ? 'text-red-600' : '' }}">
                                {{ $progress->status }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Loading or No Data State -->
            @if(count($patientProgress) == 0)
                <div class="col-span-4 text-center text-gray-500">
                    <p>No patient progress data available at the moment. Please check back later.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
