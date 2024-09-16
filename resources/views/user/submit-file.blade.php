<x-app-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex w-full justify-between items-center mb-6">
                <h2 class="uppercase font-bold text-2xl text-[#1b651b] leading-tight">
                    {{ __('Manuscript Management') }}
                </h2>
                <!-- Submit File Button -->
                @if(!$userHasManuscript)
                    <button id="submitFileButton" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none">
                        Submit File
                    </button>
                @endif
            </div>

            <!-- Modal -->
            <div id="submitFileModal" class="fixed h-screen overflow-hidden inset-0 bg-gray-800 bg-opacity-75 z-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg overflow-hidden">
                    <div class="px-6 py-4 h-screen overflow-y-auto">
                        <div class="flex justify-between items-center mb-10">
                            <h3 class="text-2xl font-semibold text-gray-900">Submit Manuscript</h3>
                            <button id="closeModalButton" class=" hover:text-gray-900 text-[40px] text-red-500">&times;</button>
                        </div>
                        <form class="" action="{{ route('manuscripts.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf

                            <div class="mb-4 flex items-center">
                                <label for="courseID" class="block text-gray-700 font-medium w-1/3">Program</label>
                                <input type="text" id="courseID" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" disabled value="{{ Auth::user()->courseID }}" required>
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="section" class="block text-gray-700 font-medium w-1/3">Year and Section</label>
                                <input type="text" name="section" id="section" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="e.g. 4-2" required>
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="title" class="block text-gray-700 font-medium w-1/3">Title</label>
                                <input type="text" name="title" id="title" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Proper capitalization format" required>
                            </div>

                            <div  class="mb-4 flex w-full justify-between gap-5">
                                <label for="author" class="block text-gray-700 font-medium">Authors</label>
                                <div id="authorsContainer" class="w-full flex flex-col justify-end items-end">   
                                    <div class="flex items-center mb-2 w-[80%]">
                                        <input type="text" name="authors[]" id="author" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required placeholder="e.g. Surname, First Name, M.I">
                                        <button type="button" id="addAuthorButton" class="ml-2 bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="adviser" class="block text-gray-700 font-medium w-1/3">Adviser</label>
                                <input type="text" name="adviser" id="adviser" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Prof. Name M.I Surname" required>
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="technical_critic" class="block text-gray-700 font-medium w-1/3">Technical Critic</label>
                                <input type="text" name="technical_critic" id="technical_critic" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Prof. Name M.I Surname" required>
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="eng_critic" class="block text-gray-700 font-medium w-1/3">English Critic</label>
                                <input type="text" name="eng_critic" id="eng_critic" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Prof. Name M.I Surname" required>
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="coordinator_id" class="block text-gray-700 font-medium w-1/3">Coordinator</label>
                                <select name="coordinator_id" id="coordinator_id" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
                                    @foreach ($subAdmins as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->fname }} {{ $sub->middlename }} {{ $sub->lname }} of {{ $sub->courseID }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="file" class="block text-gray-700 font-medium w-1/3">Upload PDF</label>
                                <input type="file" name="file" id="file" accept="application/pdf" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
                            </div>

                            <!-- New Fields -->
                            <div class="mb-4 flex items-center">
                                <label for="project_leader_staff" class="block text-gray-700 font-medium w-1/3">Project Leader Staff</label>
                                <input type="text" name="project_leader_staff" id="project_leader_staff" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="e.g. Staff Name" >
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="campus_college" class="block text-gray-700 font-medium w-1/3">Campus/College</label>
                                <input type="text" name="campus_college" id="campus_college" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="e.g. Main Campus" >
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="date_started" class="block text-gray-700 font-medium w-1/3">Date Started</label>
                                <input type="date" name="date_started" id="date_started" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" >
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="date_completed" class="block text-gray-700 font-medium w-1/3">Date Completed</label>
                                <input type="date" name="date_completed" id="date_completed" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" >
                            </div>

                            <div class="mb-4 flex items-center">
                                <label for="fund_amount" class="block text-gray-700 font-medium w-1/3">Fund Amount</label>
                                <input type="text" maxlength="5" name="fund_amount" id="fund_amount" class="w-2/3 mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" step="0.01" placeholder="e.g. 1500.00" >
                            </div>

                            <div class="flex justify-end">
                                <button type="button" id="closeModalButtonz" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancel</button>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                            <button 
                            class="ml-4 p-2 bg-red-500 text-white rounded delete-button"
                            data-id="{{ $manuscript->id }}" 
                            title="Delete my Data"
                            onclick="confirmDelete({{ $manuscript->id }})">
                            <i class="fas fa-trash"></i>
                            </button>
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

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationzModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-20 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm ">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Confirm Deletion</h3>
                    <button id="closeDeleteModalButton" class="text-gray-600 hover:text-gray-900">&times;</button>
                </div>
                <p class="mt-4 text-gray-800">Are you sure you want to delete this manuscript?</p>
                <div class="flex justify-end mt-4 z-30">
                    <button id="cancelDeletezButton" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancel</button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Modal Toggle

   
    
    document.getElementById('submitFileButton')?.addEventListener('click', function() {
        document.getElementById('submitFileModal').classList.remove('hidden');
    });

    document.getElementById('closeModalButton').addEventListener('click', function() {
        document.getElementById('submitFileModal').classList.add('hidden');
    });

    document.getElementById('closeModalButtonz').addEventListener('click', function() {
        document.getElementById('submitFileModal').classList.add('hidden');
    });

    const deleteConfirmationzModal = document.getElementById('deleteConfirmationzModal');
    const closeDeleteModalButton = document.getElementById('closeDeleteModalButton');
    const cancelDeletezButton = document.getElementById('cancelDeletezButton');

    closeDeleteModalButton.addEventListener('click', ()=>{
        deleteConfirmationzModal.classList.toggle('hidden');
        console.log('fire')
    });
    cancelDeletezButton.addEventListener('click', ()=>{
        deleteConfirmationzModal.classList.toggle('hidden');
        console.log('fire')
    });



    // Add Author Input
    document.getElementById('addAuthorButton').addEventListener('click', function() {
        const authorsContainer = document.getElementById('authorsContainer');
        const newAuthorInput = document.createElement('div');
        newAuthorInput.className = 'flex items-center mb-2 w-[80%]';
        newAuthorInput.innerHTML = `<input type="text" name="authors[]" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required placeholder="e.g. Surname, First Name, M.I">
            <button type="button" class="ml-2 bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 remove-author-button"><i class="fas fa-minus "></i></button>`;
        authorsContainer.appendChild(newAuthorInput);
    });

    // Remove Author Input
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-author-button')) {
            e.target.parentElement.remove();
        }
    });

    // Confirm Delete Function
    function confirmDelete(manuscriptId) {
        // Update the form action with the manuscript ID
        document.getElementById('deleteForm').action = `/manuscripts/${manuscriptId}`;
        // Show the delete confirmation modal
        document.getElementById('deleteConfirmationzModal').classList.remove('hidden');
    }
  
</script>

  @section('title','Manuscript Management')
</x-app-layout>
