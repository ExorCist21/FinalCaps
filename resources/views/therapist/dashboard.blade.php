<title>Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Display Admin's Posted Content -->
            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Contents Feed</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($contents as $content)
                    <div class="bg-white dark:bg-gray-800 p-5 shadow-lg rounded-lg transform transition duration-300 hover:scale-105 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-md text-gray-900 dark:text-gray-100">
                                <span class="font-semibold">{{ $content->creator->name }}</span> added a new content
                            </p>
                            <p class="text-sm text-gray-500">{{ $content->created_at->format('F j, Y') }}</p>
                        </div>

                        <!-- Content Image -->
                        @if($content->image_path)
                            <img src="{{ Storage::url($content->image_path) }}" alt="Content Image" class="w-full h-48 object-cover rounded-md mb-4 shadow-md">
                        @endif

                        <!-- Content Title -->
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $content->title }}</h3>

                        <!-- Content Description -->
                        <p class="text-sm text-gray-700 dark:text-gray-400 mb-4">{{ Str::limit($content->description, 100) }}</p>

                        <!-- Content URL -->
                        <a href="{{ $content->url }}" class="text-blue-600 hover:text-blue-800 transition duration-200">Visit Link</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
