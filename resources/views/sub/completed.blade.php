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
                <div class="p-6">
                    <h5 class="text-2xl font-bold text-center mb-4">Completed Research</h5>
                    <form id="recordForm" action="{{ route('comres.store') }}" method="POST" class="space-y-6">
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
        let authors = manuscript.author ? JSON.parse(manuscript.author) : {};
        let authorsString = Object.values(authors).join(', ');
        let parseDate = (dateStr) => {
            if (!dateStr) return '';
            let date = new Date(dateStr);
            return date.toISOString().split('T')[0]; 
        };

        let formattedDateStarted = parseDate(manuscript.date_started);
        let formattedDateCompleted = parseDate(manuscript.date_completed);

        tableData.push({
            id: r_id,
            title_research_program: manuscript.title || '',
            title_research_project: manuscript.title_research_project || '',
            project_leader_staff: manuscript.project_leader_staff || '',
            campus_college: manuscript.campus_college || '',
            date_started: formattedDateStarted,
            date_completed: formattedDateCompleted,
            funding_cvsu: manuscript.funding_cvsu || '',
            funding_external: manuscript.funding_external || '',
            ifnt_cvsu_research_type: manuscript.ifnt_cvsu_research_type || '',
            cooperating_agency: manuscript.cooperating_agency || '',
            thematic_area: manuscript.thematic_area || '',
            fund_amount: manuscript.fund_amount || '',
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
                    { title: "Campus/College", field: 'campus_college', editor: "input" },
                    { title: "Date Started", field: 'date_started', editor: "input" },
                    { title: "Date Completed", field: 'date_completed', editor: "input" },
                    { title: "Funding CVS", field: 'funding_cvsu', editor: "input" },
                    { title: "Funding External", field: 'funding_external', editor: "input" },
                    { title: "IFNT-CVSU Research Type", field: 'ifnt_cvsu_research_type', editor: "input" },
                    { title: "Cooperating Agency", field: 'cooperating_agency', editor: "input" },
                    { title: "Thematic Area", field: 'thematic_area', editor: "input" },
                    { title: "Fund Amount", field: 'fund_amount', editor: "input" },
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
                campus_college: '', 
                date_started: '', 
                date_completed: '', 
                funding_cvsu: '', 
                funding_external: '', 
                ifnt_cvsu_research_type: '', 
                cooperating_agency: '', 
                thematic_area: '', 
                fund_amount: '' 
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
    @section('title', 'Completed Research')
</x-app-layout>
