<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ApprovedManuscript;
use App\Models\User;
use Illuminate\Support\Collection;

class ApprovedManuscriptSearch extends Component
{
    public $searchTerm = '';
    public $manuscripts;

    public function mount()
    {
        // Initialize $manuscripts as an empty collection
        $this->manuscripts = collect();
    }

    public function updatedSearchTerm()
    {
        if (empty($this->searchTerm)) {
            // Reset the manuscripts collection if the search term is blank
            $this->manuscripts = collect();
        } else {
            $this->manuscripts = ApprovedManuscript::query()
                ->where('title', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('type', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('tracking_code', 'like', '%' . $this->searchTerm . '%')
                ->get()
                ->map(function ($manuscript) {
                    // Format author and coordinator information
                    $manuscript->authors = $this->parseAuthors($manuscript->author);
                    $manuscript->coordinator_name = $this->getCoordinatorName($manuscript->coordinator_id);
                    return $manuscript;
                });
        }
    }

    protected function parseAuthors($authorsString)
    {
        // Check if $authorsString is null or empty
        if (is_null($authorsString) || empty($authorsString)) {
            return [];
        }

        // Convert the authors string into an array
        $authors = json_decode($authorsString, true);
        return is_array($authors) ? $authors : [];
    }

    protected function getCoordinatorName($coordinatorId)
    {
        // Fetch the coordinator's full name from the User model
        $coordinator = User::find($coordinatorId);
        return $coordinator ? "{$coordinator->fname} {$coordinator->middlename} {$coordinator->lname}" : 'Unknown';
    }

    public function render()
    {
        return view('livewire.approved-manuscript-search');
    }
}
