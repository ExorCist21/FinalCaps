<title>Patient Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">
                {{ __('Your Content Feed') }}
            </h3>
        </div>

        @if ($contents->isEmpty())
            <p class="text-center text-gray-600">No content available at the moment.</p>
        @else
            <div id="contentsContainer" class="grid grid-cols-1">
                @foreach($contents as $content)
                    <div class="bg-white rounded-md p-6 border transition-shadow duration-200">
                        <!-- Creator Info -->
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?img={{ $content->creator->id }}"
                                 alt="Creator Avatar" 
                                 class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $content->creator->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $content->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>

                        <hr class="my-4"/>

                        <!-- Content Image -->
                        @if($content->image_path)
                            <img src="{{ Storage::url($content->image_path) }}" 
                                 alt="Content Image" 
                                 class="w-full aspect-w-16 aspect-h-9 object-cover rounded-md mb-4">
                        @endif

                        <!-- Content Title -->
                        <h3 class="text-lg font-semibold text-gray-800">{{ $content->title }}</h3>

                        <!-- Content Description -->
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($content->description, 100, '...') }}</p>

                        <!-- Content URL -->
                        <a href="{{ $content->url }}" 
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-800 mt-4 block">
                            Visit Link
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
