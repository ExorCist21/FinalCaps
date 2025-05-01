<div>
    <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}"
        class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset 
        ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-600 sm:text-sm">
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
