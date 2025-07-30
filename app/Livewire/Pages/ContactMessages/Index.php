<?php

namespace App\Livewire\Pages\ContactMessages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactMessage;

class Index extends Component
{
    use WithPagination;

    public ?ContactMessage $selected_message = null;
    public $show_message_details = false;

    public $count_unread_messages = 0;

    public $confirmMessageDeletion = false;
    public $message_to_delete = null;
    public ?int $delete_message_id = null;

    protected $listeners = [
        'confirm-message-deletion' => 'confirmMessageDeletion',
    ];

    public function mount()
    {
        $this->updateCountUnreadMessages();
    }

    public function updateCountUnreadMessages()
    {
        $this->count_unread_messages = ContactMessage::where('is_read', false)->count();
    }

    public function selectMessage($message_id)
    {
        $message = ContactMessage::findOrFail($message_id);

        if($message) {
            if(!$message->is_read) {
                $message->update(['is_read' => true]);
                $this->updateCountUnreadMessages();
            }

            $this->selected_message = $message;
            $this->show_message_details = true;
        }
    }

    public function toggleImportant()
    {
        if($this->selected_message) {
            $this->selected_message->update(['is_important' => !$this->selected_message->is_important]);
            $this->selected_message->refresh();
        }
    }

    public function confirmMessageDeletion($data)
    {
        $this->delete_message_id = $data['message_id'];
        $this->dispatch('open-modal', 'confirm-message-deletion');
    }

    public function deleteMessage()
    {
        if($this->delete_message_id) {
            $message = ContactMessage::findOrFail($this->delete_message_id);
            if($message) {
                $message->delete();

                // Clear the selection if it was the same message
                if ($this->selected_message?->id === $this->delete_message_id) {
                    $this->selected_message = null;
                    $this->show_message_details = false;
                }

                $this->delete_message_id = null;
                $this->dispatch('close-modal', 'confirm-message-deletion');
                $this->dispatch('notify', type: 'success', message: 'Message is deleted');
            }
        }
    }

    public function backToList()
    {
        $this->show_message_details = false;
    }

    public function render()
    {
        $messages = ContactMessage::latest()->paginate(12);
        $count_messages = ContactMessage::count();

        return view('livewire.pages.contact-messages.index', compact('count_messages', 'messages'));
    }
}
