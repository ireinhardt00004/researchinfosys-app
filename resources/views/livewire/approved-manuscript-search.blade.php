<div>
    <div class="mb-4 flex items-center border rounded-md shadow-sm">
        <i class="fas fa-search text-gray-500 ml-3"></i>
        <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search by title, type, or tracking code" class="w-full border-gray-300 rounded-md border-none outline-none shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg px-3 py-2 pl-10">
    </div>
    @if($manuscripts->count() === 0)
        <p class="text-gray-500">No manuscripts found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Researchers</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordinator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approved Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($manuscripts as $manuscript)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $manuscript->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($manuscript->type === 'manuscript')
                                    Manuscript
                                @elseif($manuscript->type === 'dropbox')
                                    Coordinator's Report
                                @else
                                    {{ $manuscript->type }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $manuscript->tracking_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($manuscript->authors as $author)
                                    <div>{{ $author }}</div>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $manuscript->coordinator_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $manuscript->created_at->format('F j, Y, h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
