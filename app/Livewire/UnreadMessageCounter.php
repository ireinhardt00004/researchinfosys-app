<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class UnreadMessageCounter extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount()
    {
        $userId = Auth::id();
        $this->unreadCount = Chat::where('receiver_id', $userId)
                                ->where('seen', false)
                                ->count();
    }

    public function render()
    {
        // Poll the component every second
        return view('livewire.unread-message-counter')->extends('layouts.app')->section('content')->layoutData([
            'poll' => true,
            'pollInterval' => 1000 
        ]);
    }
}
