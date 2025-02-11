<title>Content Management</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Content Management</h2>
            <button type="button" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition" onclick="openModal()">
                Add Content
            </button>
        </div>

        <!-- Modal for Adding Content -->
        <div id="contentModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[60%] max-w-5xl">
                <h3 class="text-xl font-semibold mb-4">Create New Content</h3>
                <form action="{{ route('admin.contentmng.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="creatorID" value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                <input type="url" name="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" class="mt-1 block w-full p-3 rounded-md border border-gray-300 shadow-sm text-sm text-gray-800 focus:ring-2 focus:ring-indigo-500 hover:border-indigo-400 focus:outline-none transition duration-300">
                                    <option value="Relationships" class="hover:bg-indigo-50">Relationships</option>
                                    <option value="Self Care" class="hover:bg-indigo-50">Self Care</option>
                                    <option value="Mental Health" class="hover:bg-indigo-50">Mental Health</option>
                                    <option value="Stress" class="hover:bg-indigo-50">Stress</option>
                                    <option value="Therapy & Counseling" class="hover:bg-indigo-50">Therapy & Counseling</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>
                            <div>
                                <label for="image_path" class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image_path" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-black font-semibold rounded-md hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">Create Content</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Content Display as Cards -->
        <div class="grid grid-cols-1">
            @foreach($contents as $content)
                <div class="border rounded-lg p-6 relative">
                    <!-- 3 Dots Menu -->
                    <div x-data="{ openDropdown: false, openEditModal: null }" class="absolute top-2 right-2">
                    <button @click="openDropdown = !openDropdown" class="text-gray-600 hover:text-gray-900 focus:outline-non p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 12h.01M12 12h.01M18 12h.01" />
                        </svg>
                    </button>

                    <div x-show="openDropdown" @click.outside="openDropdown = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                        <ul class="divide-y divide-gray-200">
                            <!-- Edit Button -->
                            <li>
                                <button @click="openEditModal = {{ $content->content_id }}; openDropdown = false" 
                                    class="flex text-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition duration-150">
                                    Edit
                                </button>
                            </li>
                            <!-- Delete Button -->
                            <li>
                                <form action="{{ route('admin.contentmng.delete', $content->content_id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="flex text-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition duration-150">
                                        Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>


                    <!-- Edit Modal -->
                    <div x-show="openEditModal === {{ $content->content_id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                        <div class="bg-white rounded-lg shadow-lg p-6 w-[60%] max-w-5xl relative">
                            <h3 class="text-xl font-semibold mb-4">Edit Content</h3>
                            <form action="{{ route('admin.contentmng.update', $content->content_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Left Column -->
                                    <div class="space-y-4">
                                        <div>
                                            <label for="title_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" id="title_{{ $content->content_id }}" name="title" value="{{ $content->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        </div>
                                        <div>
                                            <label for="description_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea id="description_{{ $content->content_id }}" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $content->description }}</textarea>
                                        </div>
                                        <div>
                                            <label for="url_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">URL</label>
                                            <input type="url" id="url_{{ $content->content_id }}" name="url" value="{{ $content->url }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        </div>
                                        <div>
                                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                            <select name="category" id="category" class="mt-1 block w-full p-3 rounded-md border border-gray-300 shadow-sm text-sm text-gray-800 focus:ring-2 focus:ring-indigo-500 hover:border-indigo-400 focus:outline-none transition duration-300">
                                                <option value="Relationships" class="hover:bg-indigo-50">Relationships</option>
                                                <option value="Self Care" class="hover:bg-indigo-50">Self Care</option>
                                                <option value="Mental Health" class="hover:bg-indigo-50">Mental Health</option>
                                                <option value="Stress" class="hover:bg-indigo-50">Stress</option>
                                                <option value="Therapy & Counseling" class="hover:bg-indigo-50">Therapy & Counseling</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="space-y-4">
                                        <div>
                                            <label for="image_path_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">Image</label>
                                            <div id="image-preview-{{ $content->content_id }}" class="w-full h-48 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg flex items-center justify-center">
                                                @if($content->image_path)
                                                    <img src="{{ Storage::url($content->image_path) }}" id="current-image-{{ $content->content_id }}" alt="Current Image" class="w-full h-48 object-cover rounded-lg">
                                                @else
                                                    <p class="text-center text-gray-500">No image uploaded</p>
                                                @endif
                                            </div>
                                            <input id="image_path_{{ $content->content_id }}" type="file" name="image_path" accept="image/*" class="hidden">
                                            <label for="image_path_{{ $content->content_id }}" class="cursor-pointer block mt-2 text-center text-sm text-indigo-500">Click to upload new image</label>
                                            <p id="filename-{{ $content->content_id }}" class="text-gray-500 text-xs mt-2"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-4 mt-6">
                                    <button type="button" @click="openEditModal = null" class="px-4 py-2 bg-gray-300 text-black font-semibold rounded-md hover:bg-gray-400">Cancel</button>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Update Content</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Content Info -->
                <p class="text-m"><span class="font-bold text-lg">{{ $content->creator->name }}</span> added new content</p>
                <p class="text-sm text-gray-700">{{ $content->created_at->format('F j, Y') }}</p>
                @if($content->image_path)
                    <img src="{{ Storage::url($content->image_path) }}" 
                    alt="Content Image" 
                    class="w-full aspect-w-16 aspect-h-9 max-h-[800px] object-cover rounded-md py-5">
                @endif
                <h3 class="text-lg font-semibold text-gray-900">{{ $content->title }}</h3>
                <p class="text-sm text-gray-700 mt-2">{{ $content->description }}</p>
                <a href="{{ $content->url }}" class="text-indigo-600 mt-2 block">Visit Link</a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInputs = document.querySelectorAll('[id^="image_path_"]');

        fileInputs.forEach((input) => {
            const contentId = input.id.split('_')[2]; // Extract content ID
            const previewContainer = document.querySelector(`#image-preview-${contentId}`);
            const filenameLabel = document.querySelector(`#filename-${contentId}`);

            input.addEventListener('change', (event) => {
                const file = event.target.files[0];

                if (file) {
                    // Update filename label
                    filenameLabel.textContent = `Selected File: ${file.name}`;

                    // Display new image preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewContainer.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-48 object-cover rounded-lg" alt="New Image Preview">
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Reset preview and filename
                    filenameLabel.textContent = '';
                    previewContainer.innerHTML = `<p class="text-center text-gray-500">No image uploaded</p>`;
                }
            });
        });
    });
    // Open the modal
    function openModal() {
        const modal = document.getElementById('contentModal');
        modal.classList.remove('hidden'); // Remove 'hidden' to display modal
        modal.classList.add('flex'); // Add 'flex' to enable centering
    }

    // Close the modal
    function closeModal() {
        const modal = document.getElementById('contentModal');
        modal.classList.add('hidden'); // Add 'hidden' to hide modal
        modal.classList.remove('flex'); // Remove 'flex'
    }

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