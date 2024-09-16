<x-app-layout>
    <!-- Table Section -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
        <div>
        <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">MRO / KRA Report</h2>
         
        </div>
    <div id="kra-forms" class="hidden flex flex-col items-center justify-center space-y-4 bg-gray-100 p-6 rounded-lg shadow-md">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Select MFO/KRA Form</h3>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 completed-button">Completed Research</button>
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 publication-button">Publication</button>
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 utilized-button">Utilized Research</button>
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 citation-button">Citations</button>
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 paper-presentation-button">Paper Presentation</button>
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 research-awards-button">Research Awards</button>
        <button class="text-black rounded bg-white border border-gray-300 p-3 shadow hover:bg-gray-100 invention-utility-button">Invention or Utility Models</button>
    </div>
</div>
        <div class="p-6 w-full">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">#</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Unique Tracking Code</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Sender</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Title</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Status</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">File</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Date Submitted</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($manuscripts as $manuscript)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                        <td class="px-5 py-4">
                            @if($manuscript->status === 'approved')
                                <input type="checkbox" class="row-checkbox" data-id="{{ $manuscript->id }}">
                            @endif
                        </td>
                            <td class="px-5 py-4">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">{{ $manuscript->tracking_code }}</td>
                            <td class="px-5 py-4">{{ $manuscript->user->fname }} {{ $manuscript->user->middlename }} {{ $manuscript->user->lname }}</td>
                            <td class="px-5 py-4">{{ $manuscript->title }}</td>
                            <td class="px-5 py-4 uppercase font-bold {{ $manuscript->status === 'pending' ? 'text-yellow-500' : ($manuscript->status === 'approved' ? 'text-green-500' : '') }}">{{ $manuscript->status }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ url($manuscript->file_path) }}" target="_blank" class="text-blue-600 hover:underline">View PDF</a>
                            </td>
                            <td class="px-5 py-4">{{ $manuscript->created_at->format('F j, Y, g:i A') }}</td>
                            <td class="px-5 py-4 flex items-center space-x-2">
                                <a href="{{ route('manuscripts.show', $manuscript->user_id) }}">
                                    <button title="View Sender Details" class="px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </a>
                                <!-- <button 
                                    class="delete-button p-2 bg-red-500 text-white rounded"
                                    data-id="{{ $manuscript->id }}">
                                    <i class="fas fa-trash"></i>
                                </button> -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   <!-- Deletion Confirmation Modal -->
   <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Delete Manuscript</h2>
        <p>Are you sure you want to delete this manuscript?</p>
        <div class="mt-6 flex justify-end space-x-4">
            <button id="cancelDeleteButton" class="bg-gray-500 text-white rounded px-4 py-2">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white rounded px-4 py-2">Delete</button>
            </form>
        </div>
    </div>
</div>

    <!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Approve Manuscript</h2>
        <p>Are you sure you want to approve this manuscript?</p>
        <div class="mt-6 flex justify-end space-x-4">
            <button id="cancelButton" class="bg-gray-500 text-white rounded px-4 py-2">Cancel</button>
            <form id="approveForm" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Approve</button>
            </form>
        </div>
    </div>
</div>



 <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('.min-w-full').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
             scrollX: true,
            columnDefs: [
                { orderable: false, targets: 0 }, // Disable ordering on the checkbox column
            ],
        });

        // Handle row selection
        var selectedManuscripts = [];

        $('.min-w-full').on('click', 'input[type="checkbox"]', function() {
            var manuscriptId = $(this).data('id');
            if ($(this).prop('checked')) {
                selectedManuscripts.push(manuscriptId);
            } else {
                selectedManuscripts = selectedManuscripts.filter(function(value) {
                    return value != manuscriptId;
                });
            }
        });
        // Handle completed button button click
        $('.completed-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.completed-researchindex') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
         // Handle utilized button button click
         $('.utilized-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.utilizedindex') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
         // Handle paper presentation button button click
         $('.paper-presentation-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.paper-presentation-index') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
        // Handle paper presentation button button click
        $('.research-awards-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.research-awards-index') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
         // Handle Citation button click
         $('.citation-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.citationindex') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
         // Handle Citation button click
         $('.invention-utility-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.invention-utilitymodel-index') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
        // Handle Publication button click
        $('.publication-button').click(function() {
            if (selectedManuscripts.length > 0) {
                var selectedIDs = selectedManuscripts.join(',');
                window.location.href = "{{ route('sub.publicationindex') }}" + "?ids=" + selectedIDs;
            } else {
                alert('Please select at least one manuscript.');
            }
        });
    });
</script><script>
    $(document).ready(function() {
        var selectedManuscripts = [];

        // Show/hide KRA forms div based on selection
        function toggleKraForms() {
            if (selectedManuscripts.length > 0) {
                $('#kra-forms').removeClass('hidden');
            } else {
                $('#kra-forms').addClass('hidden');
            }
        }

        // Handle row selection
        $('.min-w-full').on('click', 'input[type="checkbox"]', function() {
            var manuscriptId = $(this).data('id');
            if ($(this).prop('checked')) {
                selectedManuscripts.push(manuscriptId);
            } else {
                selectedManuscripts = selectedManuscripts.filter(function(value) {
                    return value != manuscriptId;
                });
            }
            toggleKraForms(); // Check if we should show or hide the KRA forms
        });

        // Handle select all checkbox
        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('input[type="checkbox"].row-checkbox').each(function() {
                $(this).prop('checked', isChecked);
                var manuscriptId = $(this).data('id');
                if (isChecked) {
                    if (!selectedManuscripts.includes(manuscriptId)) {
                        selectedManuscripts.push(manuscriptId);
                    }
                } else {
                    selectedManuscripts = [];
                }
            });
            toggleKraForms(); // Check if we should show or hide the KRA forms
        });
    });
</script>
<script>
    $(document).ready(function() {
    // Handle delete button click
    $('button.delete-button').click(function() {
        var manuscriptId = $(this).data('id');
        var formAction = "{{ route('manuscripts.destroy', '') }}/" + manuscriptId;
        $('#deleteForm').attr('action', formAction);
        $('#deleteModal').removeClass('hidden');
    });

    // Handle modal close (Cancel button)
    $('#cancelDeleteButton').click(function() {
        $('#deleteModal').addClass('hidden');
    });
});

</script>
<script>
    $(document).ready(function() {
        // Handle modal open
        $('button.approve-button').click(function() {
            var manuscriptId = $(this).data('id');
            var formAction = "{{ route('manuscripts.approve', '') }}/" + manuscriptId;
            $('#approveForm').attr('action', formAction);
            $('#approvalModal').removeClass('hidden');
        });

        // Handle modal close
        $('#cancelButton').click(function() {
            $('#approvalModal').addClass('hidden');
        });
    });
</script>
@section('title','MRO / KRA Forms')
</x-app-layout>
