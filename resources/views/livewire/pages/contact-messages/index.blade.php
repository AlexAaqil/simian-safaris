<div class="ContactMessages">
    <div class="messages_container">
        <!-- Messages List -->
        <div class="messages_list"
             @class([
                'absolute inset-0 z-10 bg-white' => $show_message_details,
                'hidden' => $show_message_details,
                'block' => !$show_message_details,
                'lg:relative lg:block lg:z-auto' => true
             ])
        >
            <div class="messages_header">
                <h2>Messages</h2>
                <div class="stats">
                    <span>{{ $count_messages }} messages</span>
                    <span>{{ $count_unread_messages }} unread</span>
                </div>
            </div>

            <div class="messages">
                @forelse($messages as $message)
                    <div class="message"
                         wire:key="message-{{ $message->id }}"
                         wire:click="selectMessage({{ $message->id }})"
                         @class([
                            'message',
                            'active' => $selected_message?->id === $message->id,
                            'unread' => !$message->is_read
                         ])
                    >
                        <div class="avatar">
                            <span>{{ substr($message->name, 0, 1) }}</span>
                        </div>

                        <div class="message_content">
                            <div class="header">
                                <div class="name">
                                    <h3>{{ $message->name }}</h3>
                                    @if($message->is_important)
                                        <x-svgs.star class="w-3 h-3 text-yellow-500" />
                                    @endif
                                </div>
                                <span class="date">{{ $message->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="message_body">
                                <p class="preview_text">{{ Str::limit($message->message, 50) }}</p>
                                @if (! $message->is_read)
                                    <span class="unread_badge">1</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="message">
                        <div class="message_content">
                            <h3>No messages</h3>
                            <p>You have no messages</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="pagination">{{ $messages->links() }}</div>
        </div>

        <!-- Message Details -->
        <div
            x-data="{ show: @entangle('show_message_details') }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            class="message_details"
            @class([
                'absolute inset-0 z-20 bg-white' => true,
                'hidden' => !$show_message_details,
                'block' => $show_message_details,
                'lg:relative lg:block lg:z-auto' => true
            ])
        >
            @if($selected_message)
                <div class="details_header">
                    <button
                        class="back-button lg:hidden"
                        wire:click="backToList"
                        x-on:click="show = false"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <div class="contact_details flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="contact_info flex items-center gap-3">
                            <div class="avatar w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-semibold">
                                <span>{{ substr($selected_message->name, 0, 1) }}</span>
                            </div>

                            <div class="info">
                                <h3 class="font-semibold">{{ $selected_message->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $selected_message->email }}</p>
                                <p class="text-sm text-gray-600">{{ $selected_message->phone_number }}</p>
                            </div>
                        </div>

                        <div class="actions flex gap-2 justify-start lg:justify-end">
                            <button
                                wire:click="toggleImportant"
                                class="btn_transparent p-2 rounded-lg hover:bg-gray-100"
                                @class(['important_btn', 'active' => $selected_message->is_important])
                            >
                                <x-svgs.star class="w-4 h-4 text-yellow-400" />
                            </button>

                            @if(auth()->user()->isAdmin())
                                <button
                                    x-data=""
                                    x-on:click.prevent="$wire.set('delete_message_id', {{ $selected_message->id }}); $dispatch('open-modal', 'confirm-message-deletion')"
                                    class="btn_transparent p-2 rounded-lg hover:bg-gray-100"
                                >
                                    <x-svgs.trash class="w-4 h-4 text-red-600" />
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="message_content">
                    <div class="message_bubble">
                        {{ $selected_message->message }}
                    </div>
                    <div class="message_meta">
                        <span>{{ $selected_message->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            @else
                <div class="no_message_selected">
                    <p>Select a message to view details</p>
                </div>
            @endif
        </div>
    </div>

    <x-modal name="confirm-message-deletion" :show="$delete_message_id !== null" focusable>
        <div class="custom_form">
            <form wire:submit="deleteMessage" @submit="$dispatch('close-modal', 'confirm-message-deletion')" class="p-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Confirm Deletion
                </h2>

                <p class="mt-2 mb-4 text-sm text-gray-600">
                    Are you sure you want to permanently delete this message?
                </p>

                <div class="mt-6 flex justify-start">
                    <button type="button" class="mr-2" x-on:click="$dispatch('close-modal', 'confirm-message-deletion')">
                        Cancel
                    </button>
                    <button type="submit" class="btn_danger">
                        Delete Message
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
