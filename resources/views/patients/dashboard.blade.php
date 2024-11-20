<title>Patient Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto">
            <!-- Display Admin's Posted Content -->
            <div class="mt-8">
                <h3 class="text-2xl font-semibold">Contents Feed</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    @foreach($contents as $content)
                    <div class="bg-white dark:bg-gray-800 p-4 shadow-md rounded-lg">
                    <p class="text-m">
                        <span class="font-bold text-lg">{{ $content->creator->name }}</span> added a new content
                    </p>
                    <p class="text-sm text-gray-700 mb-2">{{ $content->created_at->format('F j, Y') }}</p>

                    <!-- Content Image -->
                    @if($content->image_path)
                        <img src="{{ Storage::url($content->image_path) }}" alt="Content Image" class="w-full h-48 object-cover rounded-md mb-4">
                    @endif

                    <!-- Content Title -->
                    <h3 class="text-lg font-semibold text-gray-900">{{ $content->title }}</h3>

                    <!-- Content Description -->
                    <p class="text-sm text-gray-700 mt-2">{{ $content->description }}</p>

                    <!-- Content URL -->
                    <a href="{{ $content->url }}" class="text-blue-600 mt-2 block">Visit Link</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
