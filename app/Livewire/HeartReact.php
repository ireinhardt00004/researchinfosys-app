<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NewsReact;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class HeartReact extends Component
{
    public $announcementId;
    public $hasReacted = false;
    public $count = 0; // Add a count property

    protected $listeners = ['reactUpdated' => 'updateReact'];

    public function mount($announcementId)
    {
        $this->announcementId = $announcementId;
        $this->hasReacted = NewsReact::where('announcement_id', $this->announcementId)
            ->where('user_id', Auth::id())
            ->exists();

        // Initialize the count
        $this->count = NewsReact::where('announcement_id', $this->announcementId)
            ->count();
    }

    public function react()
    {
        $user_id = Auth::id();
        $react = NewsReact::updateOrCreate(
            ['announcement_id' => $this->announcementId, 'user_id' => $user_id],
            ['react' => !$this->hasReacted]
        );

        if (!$this->hasReacted) {
            $this->count++;
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Reacted on a news announcement'
            ]);
        } else {
            $this->count--;
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Removed the react on a news announcement'
            ]);
        }

        $this->hasReacted = !$this->hasReacted;

        
        $this->dispatch('reactUpdated');
    }

    public function render()
    {
        return view('livewire.heart-react');
    }
}
