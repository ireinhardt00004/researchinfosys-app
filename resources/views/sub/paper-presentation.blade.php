<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
    @auth
        @if (auth()->user()->hasRole('admin'))
        <a href="{{ route('admin-kraindex') }}">
            <button class="rounded bg-blue-500 p-2 text-white">
                <i class="fas fa-reply"></i> Return to the Report
            </button>
        </a>
        @endif @endauth
        @auth
        @if (auth()->user()->hasRole('sub-admin'))
        <a href="{{ route('reports.index') }}">
            <button class="rounded bg-blue-500 p-2 text-white">
                <i class="fas fa-reply"></i> Return to the Report
            </button>
        </a>
        @endif @endauth
    </div>

    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 w-full">
                    <h5 class="text-2xl font-bold text-center mb-4">Paper Presentation</h5>
                    <form id="recordForm" action="{{ route('paper-present.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="flex items-center space-x-4 mt-4">
                            <button type="button" onclick="addRow();" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fa-solid fa-plus"></i> Add Row
                            </button>
                            <button type="button" onclick="saveRecord();" class="px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 ml-auto">
                                <i class="fas fa-save"></i> Save Record
                            </button>
                        </div>
                        <input type="hidden" id="table_data" name="table_data">
                    </form>

                    <div id="table-container" class="mt-6"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let tableData = [];
        let r_id = 0;
        let table;

        // Populate initial table data with manuscript data from the server
        const manuscripts = @json($manuscripts);

        function initializeTable() {
            manuscripts.forEach((manuscript) => {
                r_id++;
                // Parse authors from JSON if present
                let authors = manuscript.author ? JSON.parse(manuscript.author) : {};
                let authorsString = Object.values(authors).join(', ');

                tableData.push({
                    id: r_id,
                    title_paper_presentation: manuscript.title || '',
                    authors: authorsString,
                    keywords: manuscript.keywords || '',
                    title_conference_symposium: manuscript.title_conference_symposium || '',
                    date: manuscript.date || '',
                    venue: manuscript.venue || '',
                    organizer: manuscript.organizer || '',
                    level: manuscript.level || '',
                });
            });

            table = new Tabulator("#table-container", {
                data: tableData,
                layout: "fitData",
                height: "400px",
                pagination: "local",
                paginationSize: 5,
                columns: [
                    { title: "Actions", formatter: actionButtons, width: 100 },
                    { title: "Row No.", field: 'id', headerSort: false, width: 75 },
                    { title: "Title of Paper Presentation", field: 'title_paper_presentation', editor: "input" },
                    { title: "Authors", field: 'authors', editor: "input" },
                    { title: "Keywords", field: 'keywords', editor: "input" },
                    { title: "Title of Conference/Symposium", field: 'title_conference_symposium', editor: "input" },
                    { title: "Date", field: 'date', editor: "input" },
                    { title: "Venue", field: 'venue', editor: "input" },
                    { title: "Organizer", field: 'organizer', editor: "input" },
                    { title: "Level (International/National/Regional/Local)", field: 'level', editor: "select", editorParams: {
                        values: {
                            "International": "International",
                            "National": "National",
                            "Regional": "Regional",
                            "Local": "Local"
                        }
                    }},
                ],
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            initializeTable();
        });

        function actionButtons(cell) {
            return `<button type="button" onclick="deleteRow(${cell.getRow().getIndex()})" class="px-2 py-1 bg-red-500 text-white rounded-md shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fa-solid fa-trash"></i>
                    </button>`;
        }

        function addRow() {
            r_id++;
            table.addData([{ 
                id: r_id, 
                title_paper_presentation: '', 
                authors: '', 
                keywords: '', 
                title_conference_symposium: '', 
                date: '', 
                venue: '', 
                organizer: '', 
                level: ''
            }]);
        }

        function deleteRow(rowIndex) {
            table.deleteRow(rowIndex);
        }

        function saveRecord() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This report will be sent to the admin for reviewing and verification.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, serialize the table data and submit the form
                let data = table.getData();
                document.getElementById('table_data').value = JSON.stringify(data);
                document.getElementById('recordForm').submit();
            }
        });
    }

    // Check for success or error messages
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ $errors->first() }}',
                showConfirmButton: true
            });
        @endif
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@5.5.0/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('title', 'Paper Presentation')
</x-app-layout>
