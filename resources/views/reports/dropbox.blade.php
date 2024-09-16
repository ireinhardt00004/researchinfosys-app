<x-app-layout>
    <!-- Table Section -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
        <div> <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">Drop Box</h2>
        </div>    
    <div class="p-6">
            <table class="min-w-full leading-normal" id="manuscriptTable">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">#</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Unique Tracking Code</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Title</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Status</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">File</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Comment From Admin</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Date Submitted</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($manuscripts as $manuscript)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="px-5 py-4">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">{{ $manuscript->tracking_code }}</td>
                            <td class="px-5 py-4">{{ $manuscript->title }}</td>
                            <td class="px-5 py-4 uppercase font-bold 
                                {{ $manuscript->status === 'pending' ? 'text-yellow-500' : 
                                ($manuscript->status === 'approved' ? 'text-green-500' : 
                                ($manuscript->status === 'for revision' ? 'text-red-500' : '')) }}">
                                {{ $manuscript->status }}
                            </td>
                             <td class="px-5 py-4">
                                <a href="{{ url($manuscript->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Download Excel</a>
                            </td>
                            <td class="px-5 py-4">
                            @if($manuscript->comment)
                                {{ $manuscript->comment }}
                            @else
                                No Comment yet.
                            @endif
                            </td>
                            <td class="px-5 py-4">{{ $manuscript->created_at->format('F j, Y, g:i A') }}</td>
                            <td class="px-5 py-4 flex items-center space-x-2">
                                @if($manuscript->status != 'approved')
                                    <button title="Re-upload a report" data-id="{{ $manuscript->id }}" class="re_upload-button px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                @endif
                                <button 
                                    class="delete-button p-2 bg-red-500 text-white rounded hover:bg-red-600"
                                    data-id="{{ $manuscript->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Approval Modal -->
    <div id="approvalModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 z-30 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 shadow-lg max-w-lg w-full">
            <h2 class="text-xl font-semibold mb-4">Re-upload a Report</h2>
            <p class="mb-4">Please select a file to upload for the selected manuscript.</p>
            <form id="approveForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="mb-4 p-2 border border-gray-300 rounded w-full">
                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancelButton" class="bg-gray-500 text-white rounded px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts for DataTables and Modal -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#manuscriptTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                 scrollX: true,
                columnDefs: [
                    { orderable: false, targets: 6 } 
                ]
            });

            // Handle modal open
            $(document).on('click', '.re_upload-button', function() {
                var manuscriptId = $(this).data('id');
                var formAction = "{{ route('dropbox.reupload', '') }}/" + manuscriptId;
                $('#approveForm').attr('action', formAction);
                $('#approvalModal').removeClass('hidden');
            });

            // Handle modal close
            $('#cancelButton').click(function() {
                $('#approvalModal').addClass('hidden');
            });

            // Handle delete confirmation
            $(document).on('click', '.delete-button', function() {
                var manuscriptId = $(this).data('id');
                if (confirm('Are you sure you want to delete this report?')) {
                    $.ajax({
                        url: "{{ route('dropbox.delete', '') }}/" + manuscriptId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            location.reload(); // Reload the page after successful delete
                        },
                        error: function(response) {
                            alert('An error occurred while deleting the manuscript.');
                        }
                    });
                }
            });
        });
    </script>
    
    @section('title', 'My Drop Box')
</x-app-layout>
