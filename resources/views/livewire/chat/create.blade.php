<title>Select Chats</title>
<x-app-layout>
    <div class="container mx-auto">
        <h2 class="text-xl font-bold">Start a New Conversation</h2>

        <div class="mt-4">
            @foreach($users as $user)
                <div class="flex items-center justify-between border-b py-2">
                    <span>{{ $user->name }}</span>
                    <a href="{{ route('chat.show', ['id' => $user->id]) }}" class="text-blue-500">
                        Start Chat
                    </a>
                </div>
            @endforeach
        </div>
        <livewire:chat.chat-list />
    </div>
</x-app-layout>
