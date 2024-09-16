<?php 
namespace App\Livewire;
use Livewire\Component;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatPanel extends Component
{
    public $search = '';
    public $currentChatUserId;
    public $hasResults = false;
    public $pollInterval = 1000; 
    protected $listeners = [
        'refreshChatMessages' => '$refresh',
        'userSelected' => 'loadMessages'
    ];

    public function mount()
    {
        $this->currentChatUserId = session('currentChatUserId', null);
    }

    public function selectUser($userId)
    {
        $this->currentChatUserId = $userId;
        session(['currentChatUserId' => $userId]);

        $chat = Chat::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })
        ->first();

        if (!$chat) {
            // Create chat if it does not exist
            Chat::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $userId,
                'message' => '',
                'seen' => false,
                'favorite' => false,
                'archive' => false
            ]);
        }

        $this->dispatch('userSelected', $userId);
    }

    public function searchUsers()
    {
        if (empty($this->search)) {
            $this->hasResults = false;
            return [];
        }

        $users = User::where('lname', 'like', '%' . $this->search . '%')
                     ->orWhere('fname', 'like', '%' . $this->search . '%')
                     ->orWhere('middlename', 'like', '%' . $this->search . '%')
                     ->get();

        $this->hasResults = $users->count() > 0;
        return $users;
    }

    public function unreadMessagesCount($userId)
    {
        return Chat::where('receiver_id', Auth::id())
                    ->where('sender_id', $userId)
                    ->where('seen', false)
                    ->count();
    }

    public function render()
    {
        // Get all chats involving the authenticated user
        $userChats = Chat::where(function ($query) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })->get();

        // Get unique users involved in the chats
        $userIds = $userChats->pluck('sender_id')->merge($userChats->pluck('receiver_id'))->unique()->filter(function ($userId) {
            return $userId != Auth::id();
        });

        $chatUsers = User::whereIn('id', $userIds)->get();

        // Add unread messages count for each user
        foreach ($chatUsers as $user) {
            $user->unreadMessagesCount = $this->unreadMessagesCount($user->id);
            $user->recentMessage = Chat::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->first();
        }

        return view('livewire.chat-panel', [
            'searchResults' => $this->searchUsers(),
            'chatUsers' => $chatUsers
        ])->extends('layouts.app')->section('content');
    }
}
