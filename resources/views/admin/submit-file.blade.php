<x-app-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex w-full justify-between items-center mb-6">
                <h2 class="font-bold uppercase text-2xl text-[#1b651b] leading-tight">
                    {{ __('Researcher Details') }}
                </h2>
              
            </div>
            <!-- Manuscript Cards Section -->
            <div class="grid sm:grid-cols-2 grid-cols-1 w-full h-full gap-3">
                <div class="w-full drop-shadow-xl">
                @foreach ($manuscripts as $manuscript)
                    <div class="bg-white shadow rounded-lg p-6 w-full text-1xl space-y-5">
                        <div class="flex items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $manuscript->title }}</h3>
                        </div>
                        <p class="text-gray-600 mb-2">Tracking Code: <span class="font-bold">{{ $manuscript->tracking_code }}</span></p>
                        <p class="text-gray-600 mb-2">Author(s):</p>
                        <ul class="list-disc pl-5 ms-5">
                            @php
                                $authors = json_decode($manuscript->author, true);
                            @endphp
                            @if(is_array($authors))
                                @foreach($authors as $author)
                                    <li class="text-gray-600">{{ $author }}</li>
                                @endforeach
                            @else
                                <li class="text-gray-600">No authors listed</li>
                            @endif
                        </ul>
                        <p class="text-gray-600 mb-2">Course, Year and Section: <span class="font-bold">{{ Auth::user()->courseID }}  {{ $manuscript->section }}</span></p>
                        <p class="text-gray-600 mb-2">Thesis Adviser: <span class="font-bold">{{ $manuscript->adviser }}</span></p>
                        <p class="text-gray-600 mb-2">Technical Critic: <span class="font-bold">{{ $manuscript->technical_critic }}</span></p>
                        <p class="text-gray-600 mb-2">English Critic: <span class="font-bold">{{ $manuscript->eng_critic }}</span></p>
                        <p class="text-gray-600 mb-2">Status: <span class="font-bold uppercase">{{ $manuscript->status }}</span></p>
                        <p class="text-gray-600 mb-2">Submitted On: <span class="font-bold">{{ $manuscript->created_at->format('d/m/Y') }}</span></p>
                        <div class="flex items-center mt-4">
                            <a href="{{ url($manuscript->file_path) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View PDF</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Display Manuscript Information -->
    @if($manuscripts->isNotEmpty())
    @php
        // You can handle date parsing here if needed, or in the controller
        $firstManuscript = $manuscripts->first();
        $dateStarted = $firstManuscript->date_started ? \Carbon\Carbon::parse($firstManuscript->date_started) : null;
        $dateCompleted = $firstManuscript->date_completed ? \Carbon\Carbon::parse($firstManuscript->date_completed) : null;
    @endphp
    <!-- Additional Information Card Section -->
    <div class="w-full bg-white shadow rounded-lg p-6 text-1xl drop-shadow-xl">
        <h3 class="text-xl font-semibold text-gray-900">Additional Information</h3>
        <div class="mt-4">
            <ul class="list-disc pl-5 space-y-5">
                <li class="text-gray-600">Project Leader Staff: <span class="font-bold">{{ $firstManuscript->project_leader_staff ?? 'N/A' }}</span></li>
                <li class="text-gray-600">Campus/College: <span class="font-bold">{{ $firstManuscript->campus_college ?? 'N/A' }}</span></li>
                <li class="text-gray-600">Date Started: <span class="font-bold">{{ $dateStarted ? $dateStarted->format('d/m/Y') : 'N/A' }}</span></li>
                <li class="text-gray-600">Date Completed: <span class="font-bold">{{ $dateCompleted ? $dateCompleted->format('d/m/Y') : 'N/A' }}</span></li>
                <li class="text-gray-600">Fund Amount: <span class="font-bold">{{ $firstManuscript->fund_amount ? number_format($firstManuscript->fund_amount, 2) : 'N/A' }}</span></li>
            </ul>
        </div>
    </div>
</div>
@endif  

<!-- PDF Previewer Section -->
@if($manuscripts->isNotEmpty())
<div class="mt-8 w-full bg-white shadow rounded-lg ">
    <div class="p-6 h-full drop-shadow-xl ">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">PDF Previewer</h3>
        <div class="border rounded-lg overflow-hidden">
            @php
                $firstManuscript = $manuscripts->first();
            @endphp
            <iframe src="{{ url($firstManuscript->file_path) }}" class="w-full h-[80vh]" frameborder="0"></iframe>
        </div>
    </div>
</div>
@endif

  @section('title','Researcher Details')
</x-app-layout>
