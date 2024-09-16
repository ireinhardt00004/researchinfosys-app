<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\ChatFavorite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatComponent extends Component
{
    public $currentChatUserId;
    public $messages;
    public $newMessage;
    public $recipientName;
    public $profilepic;
    public $isFavorite = false;
    public $pollInterval = 1000; 

    protected $listeners = [
        'messageSent' => 'loadMessages',
        'userSelected' => 'loadMessages',
        'confirmDeleteConversation' => 'deleteConversation',
        'toggleFavorite' => 'toggleFavorite'
    ];
    public function mount()
    {
        $this->currentChatUserId = session('currentChatUserId', null);
        $this->loadMessages($this->currentChatUserId);
    }
    public function loadMessages($userId = null)
    {
        $userId = $userId ?: $this->currentChatUserId;
        if ($userId) {
            $this->currentChatUserId = $userId;

            // Mark messages as seen
            Chat::where('receiver_id', Auth::id())
                ->where('sender_id', $userId)
                ->update(['seen' => true]);
            // Load messages
            $this->messages = Chat::where(function ($query) use ($userId) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
            // Load recipient's full name and profile picture
            $recipient = User::find($userId);
            if ($recipient) {
                $this->recipientName = trim("{$recipient->fname} {$recipient->middlename} {$recipient->lname}");

                // Check if the chat is a favorite
                $this->isFavorite = ChatFavorite::where('user_id', Auth::id())
                    ->where('chat_id', $userId)
                    ->exists();

                $this->profilepic = $recipient->userinfos ? $recipient->userinfos->profile_pic : 'default_profile_pic.jpg';
            }
        }
    }
    public function sendMessage()
    {
        if ($this->newMessage) {
            Chat::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->currentChatUserId,
                'message' => $this->newMessage
            ]);

            $this->newMessage = '';
            $this->dispatch('messageSent');
        }
    }
    public function confirmDeleteConversation()
    {
        $this->dispatch('show-confirmation-dialog', [
            'message' => 'Are you sure you want to delete the entire conversation?',
            'callback' => 'deleteConversation'
        ]);
    }
    public function deleteConversation()
    {
        if ($this->currentChatUserId) {
            Chat::where(function ($query) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $this->currentChatUserId);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->currentChatUserId)
                      ->where('receiver_id', Auth::id());
            })
            ->delete();

            // Also delete from favorites if exists
            ChatFavorite::where('user_id', Auth::id())
                ->where('chat_id', $this->currentChatUserId)
                ->delete();

            // Optionally dispatch an event or handle post-deletion logic
            $this->dispatch('conversationDeleted');
            $this->loadMessages(); // Refresh the messages list
        }
    }

    public function toggleFavorite()
    {
        // Check if the chat is already favorited
        $chatFavorite = ChatFavorite::where('user_id', Auth::id())
            ->where('chat_id', $this->currentChatUserId)
            ->first();

        if ($chatFavorite) {
            // Remove from favorites
            $chatFavorite->delete();
            $this->isFavorite = false;
        } else {
            // Ensure chat_id exists before inserting
            $chatExists = Chat::where('id', $this->currentChatUserId)->exists();

            if ($chatExists) {
                // Add to favorites
                ChatFavorite::create([
                    'user_id' => Auth::id(),
                    'chat_id' => $this->currentChatUserId
                ]);
                $this->isFavorite = true;
            } else {
                // Handle the case where chat_id does not exist
                session()->flash('error', 'Chat does not exist.');
            }
        }
    }
    public function render()
    {
        return view('livewire.chat-component')->extends('layouts.app')->section('content');
    }
}
