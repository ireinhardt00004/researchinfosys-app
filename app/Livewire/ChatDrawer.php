<?php 
namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatDrawer extends Component
{
    public $messages = [];
    public $isVisible = false;

    protected $listeners = [
        'messageSent' => 'loadMessages',
        'refreshChatDrawer' => 'loadMessages',
    ];

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
{
    $userId = Auth::id();

    // Fetch all chats involving the current user, ordered by the latest message first
    $chats = Chat::where('sender_id', $userId)
                 ->orWhere('receiver_id', $userId)
                 ->orderBy('created_at', 'desc')
                 ->get();

    // Group by sender_id and keep the latest message for each sender
    $latestChats = $chats->groupBy(function ($chat) {
        return $chat->sender_id; // Group by sender_id
    })->map(function ($group) {
        return $group->first(); // Take the latest message from each sender
    });

    // Map the latest messages to the desired format
    $formattedChats = $latestChats->map(function ($chat) {
        $message = $chat->message ?? ''; // Handle null or undefined message
        $sender = User::find($chat->sender_id);
        return [
            'sender' => $sender->fname . ' ' . ($sender->middlename ? $sender->middlename . ' ' : '') . $sender->lname,
            'message_preview' => implode(' ', array_slice(explode(' ', $message), 0, 3)),
            'message' => $message,
            'is_read' => $chat->is_read ?? false, // Assuming you have an 'is_read' attribute
        ];
    });

    $this->messages = $formattedChats;
    }

    
    public function toggleDrawer()
    {
        $this->isVisible = !$this->isVisible;
    }

    public function render()
    {
        return view('livewire.chat-drawer');
    }
}
