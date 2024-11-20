<title>Content Management</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-4">Content Management</h2>

        <!-- Button to open the modal -->
        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700" onclick="openModal()">
            Add Content
        </button>

        <!-- Modal for Adding Content -->
        <div id="contentModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h3 class="text-xl font-semibold mb-4">Create New Content</h3>
                <form action="{{ route('admin.contentmng.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="creatorID" value="{{ \App\Models\User::where('role', 'admin')->first()->id }}">

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                        </div>

                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                            <input type="url" name="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label for="image_path" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image_path" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="flex justify-end space-x-2 mt-4">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-black font-semibold rounded-md hover:bg-gray-400">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">Create Content</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Content Display as Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
    @foreach($contents as $content)
        <div class="bg-white shadow-md rounded-lg p-4 relative">

            <!-- 3 Dots Menu (Top Right Corner) -->
            <div x-data="{ openDropdown: false, openEditModal: null }" class="absolute top-2 right-2">

                <!-- Three dots button -->
                <button @click="openDropdown = !openDropdown" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h12M6 6h12M6 18h12"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="openDropdown" @click.outside="openDropdown = false" class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg z-10">
                    <ul>
                        <li>
                        <button @click="openEditModal = {{ $content->content_id }}; openDropdown = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Edit
                        </button>

                        </li>
                        <li>
                            <form action="{{ route('admin.contentmng.delete', $content->content_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                                    Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Edit Modal -->
                <div x-show="openEditModal === {{ $content->content_id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                        <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
                            <h3 class="text-xl font-semibold mb-4">Edit Content</h3>
                            <form action="{{ route('admin.contentmng.update', $content->content_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 gap-1">
                                    <div>
                                        <label for="title_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" id="title_{{ $content->content_id }}" name="title" value="{{ $content->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    </div>

                                    <div>
                                        <label for="description_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="description_{{ $content->content_id }}" rows="1" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ $content->description }}</textarea>
                                    </div>

                                    <div>
                                        <label for="url_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">URL</label>
                                        <input type="url" id="url_{{ $content->content_id }}" name="url" value="{{ $content->url }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    </div>
                                    <div>
                                        <label for="image_path_{{ $content->content_id }}" class="block text-sm font-medium text-gray-700">Image</label>

                                        <!-- Old Image Preview -->
                                        <div id="image-preview-{{ $content->content_id }}" class="w-full p-4 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg">
                                            @if($content->image_path)
                                                <img src="{{ Storage::url($content->image_path) }}" id="current-image-{{ $content->content_id }}" alt="Current Image" class="w-full h-48 object-cover rounded-lg mb-4">
                                            @else
                                                <p class="text-center text-gray-500">No image uploaded</p>
                                            @endif
                                        </div>

                                        <!-- File Input -->
                                        <input id="image_path_{{ $content->content_id }}" type="file" name="image_path" accept="image/*" class="hidden">
                                        <label for="image_path_{{ $content->content_id }}" class="cursor-pointer block mt-2 text-center text-sm text-blue-500">Click to upload new image</label>
                                        <p id="filename-{{ $content->content_id }}" class="text-gray-500 text-xs mt-2"></p>
                                    </div>


                                    <div class="flex justify-end space-x-2 mt-1">
                                        <button type="button" @click="openEditModal = null" class="px-4 py-2 bg-gray-300 text-black font-semibold rounded-md hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                                            Update Content
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <!-- Content Info -->
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

    <!-- JavaScript for Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    // Select all file inputs
    const fileInputs = document.querySelectorAll('[id^="image_path_"]');

    fileInputs.forEach((input) => {
        const contentId = input.id.split('_')[2]; // Extract content ID
        const previewContainer = document.querySelector(`#image-preview-${contentId}`);
        const filenameLabel = document.querySelector(`#filename-${contentId}`);

        // Add event listener for each input
        input.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                // Display filename
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
                // Reset preview and filename if no file selected
                filenameLabel.textContent = '';
                previewContainer.innerHTML = `<p class="text-center text-gray-500">No image uploaded</p>`;
            }
        });
    });
});


        // Open the modal
        function openModal() {
            document.getElementById('contentModal').classList.remove('hidden');
        }

        // Close the modal
        function closeModal() {
            document.getElementById('contentModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
