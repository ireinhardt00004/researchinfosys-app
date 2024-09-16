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
                    <h5 class="text-2xl font-bold text-center mb-4">Publication</h5>
                    <form id="recordForm" action="{{ route('exportz.store') }}" method="POST" class="space-y-6">
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
        const manuscripts = @json($manuscripts);

        function initializeTable() {
         manuscripts.forEach((manuscript) => {
        r_id++;
        // Parse authors from JSON if present
        let authors = manuscript.author ? JSON.parse(manuscript.author) : {};
        let authorsString = Object.values(authors).join(', ');

        // Function to format date
        const formatDate = (dateStr) => {
            if (!dateStr) return ''; 
            let date = new Date(dateStr);
            return date.toISOString().split('T')[0];
        };

        let formattedDateStarted = formatDate(manuscript.date_started);
        let formattedDateCompleted = formatDate(manuscript.date_completed);

        tableData.push({
            id: r_id,
            title_research_program: manuscript.title || '',
            title_research_project: manuscript.title_research_project || '', 
            project_leader_staff: manuscript.project_leader_staff || '', 
            CampusCollegeRDE_Unit: manuscript.campus_college || '',
            duration_started: formattedDateStarted,
            duration_completed: formattedDateCompleted,
            type_research: manuscript.research_type || '',
            title_article_book: manuscript.article_title || '',
            name_of_journal: manuscript.journal_name || '', 
            keywords: manuscript.keywords || '',
            authors: authorsString,
            volume_issue: manuscript.volume_issue || '',
            date_publication: manuscript.date_publication || '',
            publication_type: manuscript.publication_type || '',
            issn_isbn: manuscript.issn_isbn || '',
            indexing_ched: manuscript.indexing_ched || '',
            remarks_pub: manuscript.remarks_pub || '',
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
            { title: "Title of Research Program", field: 'title_research_program', editor: "input" },
            { title: "Title of Research Project", field: 'title_research_project', editor: "input" },
            { title: "Project Leader and Staff", field: 'project_leader_staff', editor: "input" },
            { title: "Campus/College/RDE Unit", field: 'CampusCollegeRDE_Unit', editor: "input" },
            { title: "Date Started (Duration)", field: 'duration_started', editor: "input" },
            { title: "Date Completed (Duration)", field: 'duration_completed', editor: "input" },
            { title: "Type of Research", field: 'type_research', editor: "input" },
            { title: "Title of Article/Book Chapter", field: 'title_article_book', editor: "input" },
            { title: "Name of Journal / Book", field: 'name_of_journal', editor: "input" },
            { title: "Keywords", field: 'keywords', editor: "input" },
            { title: "Author/s", field: 'authors', editor: "input" },
            { title: "Vol No. (Issue No): Pages", field: 'volume_issue', editor: "input" },
            { title: "Date of Publication", field: 'date_publication', editor: "input" },
            { 
            title: "Type of Publication (International/National/Regional/Local)", 
            field: 'publication_type', 
            editor: "select",
            editorParams: {
                values: {
                    "International": "International",
                    "National": "National",
                    "Regional": "Regional",
                    "Local": "Local"
                }
            }
        },
            { title: "ISSN/ ISBN", field: 'issn_isbn', editor: "input" },
            { title: "Indexing (CHED, ISI, Scopus, ASCI, etc.)", field: 'indexing_ched', editor: "input" },
            { title: "REMARKS  (To be filled-up by M and E Division)", field: 'remarks_pub', editor: "input" },
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
                title_research_program: '', 
                title_research_project: '', 
                project_leader_staff: '', 
                CampusCollegeRDE_Unit: '', 
                duration_started: '', 
                duration_completed: '', 
                type_research: '', 
                title_article_book: '', 
                name_of_journal: '', 
                keywords: '', 
                authors: '' 
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
    @section('title', 'Publication')
</x-app-layout>
