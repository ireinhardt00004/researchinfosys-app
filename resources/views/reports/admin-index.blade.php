<x-app-layout>
    <!-- Table Section -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
    <div> <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">Coordinator's Report</h2>
    </div>
        <div class="p-6 w-full">
            <table class="!leading-normal !w-full !table-auto" id="manuscriptsTable">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">#</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Unique Tracking Code</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Sender</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Title</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Status</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">File</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Comment</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Date Submitted</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($manuscripts as $manuscript)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="px-5 py-4">{{ $loop->iteration }}</td>
                            <td class="px-5 py-4">{{ $manuscript->tracking_code }}</td>
                            <td class="px-5 py-4">{{ $manuscript->user->fname }} {{ $manuscript->user->middlename }} {{ $manuscript->user->lname }}</td>
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
                                {{ $manuscript->comment ?? 'No Comment yet.' }}
                            </td>
                            <td class="px-5 py-4">{{ $manuscript->created_at->format('F j, Y, g:i A') }}</td>
                            <td class="px-5 py-4 flex items-center space-x-2">
                                @if($manuscript->status !== 'approved')
                                    <button title="Approve this Report" data-id="{{ $manuscript->id }}" class="approve-button px-3 py-2 bg-blue-500 text-white rounded hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button title="Revise this Report" data-id="{{ $manuscript->id }}" class="revise-button px-3 py-2 bg-green-500 text-white rounded hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif
                                <button 
                                    class="delete-button p-2 bg-red-500 text-white rounded"
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
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Approve Report</h2>
            <p>Are you sure you want to approve this report?</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button id="cancelButton" class="bg-gray-500 text-white rounded px-4 py-2">Cancel</button>
                <form id="approveForm" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2">Approve</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Revise Modal -->
    <div id="reviseModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Revise Report</h2>
            <p>Provide comments for revising this report:</p>
            <form id="reviseForm" method="POST" action="{{ route('drop-report.revise') }}">
                @csrf
                <textarea name="comments" rows="4" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter comments here..."></textarea>
                <input type="hidden" id="reviseFormId" name="manuscript_id">
                <div class="mt-6 flex justify-end space-x-4">
                    <button id="cancelReviseButton" class="bg-gray-500 text-white rounded px-4 py-2">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white rounded px-4 py-2">Revise</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#manuscriptsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                scrollX: true,
                columnDefs: [
                    { orderable: false, targets: [8] } // Disable ordering on the Action column
                ],
            });

            // Handle approval modal
            $('.approve-button').click(function() {
                var manuscriptId = $(this).data('id');
                var formAction = "{{ route('drop-report.approve', '') }}/" + manuscriptId;
                $('#approveForm').attr('action', formAction);
                $('#approvalModal').removeClass('hidden');
            });

            $('#cancelButton').click(function() {
                $('#approvalModal').addClass('hidden');
            });

            // Handle revise modal
            $('.revise-button').click(function() {
                var manuscriptId = $(this).data('id');
                $('#reviseFormId').val(manuscriptId);
                $('#reviseForm').attr('action', "{{ route('drop-report.revise') }}");
                $('#reviseModal').removeClass('hidden');
            });

            $('#cancelReviseButton').click(function() {
                $('#reviseModal').addClass('hidden');
            });

            // Handle delete button
            $('.delete-button').click(function() {
                if (confirm('Are you sure you want to delete this manuscript?')) {
                    var manuscriptId = $(this).data('id');
                    $.ajax({
                        url: "{{ route('dropbox.delete', '') }}/" + manuscriptId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function() {
                            alert('An error occurred while trying to delete the manuscript.');
                        }
                    });
                }
            });
        });
    </script>
    @section('title','Coordinators Report')
</x-app-layout>
