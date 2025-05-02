<title>Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-r from-blue-100 via-purple-100 to-pink-100 py-8"> <!-- Gradient Background -->
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-black-800 dark:text-black-100">
                    {{ __('Your Content Feed') }}
                </h3>

                <!-- Filter Dropdown -->
                <form method="GET" action="{{ route('patients.dashboard') }}" class="flex items-center">
                    <select name="category" class="p-2 rounded-lg border border-gray-300 bg-white shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
                        <option value="">All Categories</option>
                        <option value="Relationships" {{ request('category') == 'Relationships' ? 'selected' : '' }}>Relationships</option>
                        <option value="Self Care" {{ request('category') == 'Self Care' ? 'selected' : '' }}>Self Care</option>
                        <option value="Mental Health" {{ request('category') == 'Mental Health' ? 'selected' : '' }}>Mental Health</option>
                        <option value="Stress" {{ request('category') == 'Stress' ? 'selected' : '' }}>Stress</option>
                        <option value="Therapy & Counseling" {{ request('category') == 'Therapy & Counseling' ? 'selected' : '' }}>Therapy & Counseling</option>
                    </select>
                    <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring focus:ring-indigo-300">
                        Filter
                    </button>
                </form>
            </div>

            @if ($contents->isEmpty())
                <p class="text-center text-gray-600 text-lg">No content available for the selected category.</p>
            @else
                <div id="contentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"> <!-- Responsive grid with spacing -->
                    @foreach($contents as $content)
                        <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-lg transition-transform duration-300 transform hover:scale-105 hover:shadow-xl"> <!-- Card with hover effect -->
                            <!-- Creator Info -->
                            <div class="flex items-center mb-4">
                                <img src="https://i.pravatar.cc/150?img={{ $content->creator->id }}"
                                     alt="Creator Avatar"
                                     class="w-14 h-14 ring-4 ring-indigo-300 rounded-full object-cover mr-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 capitalize">{{ $content->creator->first_name }} {{ $content->creator->last_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $content->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>

                            <hr class="my-4 border-gray-200"/>

                            <!-- Content Image -->
                            @if($content->image_path)
                                <img src="{{ Storage::url($content->image_path) }}" 
                                     alt="Content Image" 
                                     class="w-full aspect-w-16 aspect-h-9 object-cover rounded-md mb-4 shadow-md">
                            @endif

                            <!-- Content Title -->
                            <h3 class="text-xl font-semibold text-gray-800 mt-2">{{ $content->title }}</h3>

                            <!-- Content Description -->
                            <p class="text-sm text-gray-800 mt-2">{{ Str::limit($content->description, 120, '...') }}</p>
                            <h3 class="text-sm font-semibold text-gray-800 mt-2">{{ $content->category }}</h3>

                            <!-- Content URL -->
                            <a href="{{ $content->url }}" 
                               class="inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800 mt-4 transition-colors duration-200">
                                <span class="bg-indigo-100 px-3 py-1 rounded-lg hover:bg-indigo-200">Visit Link</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if(session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: "#4CAF50",
                    confirmButtonText: "OK"
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#E53935",
                    confirmButtonText: "OK"
                });
            @endif
        });
    </script>
</x-app-layout>
