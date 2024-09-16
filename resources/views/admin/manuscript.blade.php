<x-app-layout>
    <!-- Table Section -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
        <div>
            <h2 class="text-2xl font-bold m-3 uppercase text-[#1B651B]">List of Researchers</h2>
        </div>
        <div class="p-6 w-full overflow-x-auto">
            <table class="w-full table-auto" id="manuscriptsTable">
                <thead>
                    <tr>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">#</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Unique Tracking Code</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Sender</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Title</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Status</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">File</th>
                        <th class="px-5 py-3 bg-gray-50 text-gray-600 text-left text-sm uppercase font-medium">Course</th>
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
                                <a href="{{ url($manuscript->file_path) }}" target="_blank" class="text-blue-600 hover:underline">View PDF</a>
                            </td>
                            <td class="px-5 py-4">
                                {{ $manuscript->user->courseID }} 
                            </td>
                            <td class="px-5 py-4">{{ $manuscript->created_at->format('F j, Y, g:i A') }}</td>
                            <td class="px-5 py-4 flex items-center space-x-2">
                            <button 
                                class="p-2 bg-green-500 text-white rounded"
                                onclick="viewDetails({{ $manuscript->user_id }})"
                                title="View Researchers Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
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
                { orderable: false, targets: [8] } 
            ],
        });
    });

    function viewDetails(manuscriptId) {
        window.location.href = '/manuscripts/view/' + manuscriptId; 
    }
</script>   
    @section('title','List of Researchers')
</x-app-layout>
