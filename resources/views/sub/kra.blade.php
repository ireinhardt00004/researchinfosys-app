<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div>
        <a href="{{ route('reports.index') }}"
            <button class="rounded bg-blue-500 p-2 text-white"><i class="fas fa-reply"></i> Return to the Report</button>
        </a>
        </div>
    <div class="py-12 w-full">
        <div class="max-w-7xl  mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="text-2xl font-bold text-center mb-4">{{$manuscript->title}}</h5>
                    <form id="recordForm" action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tracking_code" class="block text-sm font-medium text-gray-700">Tracking Code</label>
                                <input id="tracking_code" name="tracking_code" disabled value="{{$manuscript->tracking_code}}" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <input id="status"  disabled value="{{$manuscript->status}}" type="text" required class="uppercase mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">Author/s</label>
                            <textarea id="author" name="author" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @php
                                    $authors = json_decode($manuscript->author, true);
                                @endphp
                                
                                @if($authors)
                                    @foreach($authors as $key => $author)
                                        {{ ucwords(str_replace('_', ' ', $key)) }}: {{ $author }}
                                        @if(!$loop->last)
                                        @endif
                                    @endforeach
                                @else
                                    No authors available
                                @endif
                            </textarea>
                        </div>

                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700">Course, Year and Section</label>
                                <input id="course"  disabled value="{{$manuscript->user->courseID }} - {{$manuscript->section }}" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="adviser" class="block text-sm font-medium text-gray-700">Thesis Adviser</label>
                                <input id="adviser"  disabled value="{{$manuscript->adviser }}" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="technical_critic" class="block text-sm font-medium text-gray-700">Technical Critic</label>
                                <input id="technical_critic"  disabled value="{{$manuscript->technical_critic }}" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="housingType" class="block text-sm font-medium text-gray-700">Uri ng Pamamahay</label>
                                    <select id="housingType" name="housingType" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled selected>-- Please select --</option>
                                        <option value="1">May Ari</option>
                                        <option value="2">Squat</option>
                                        <option value="3">Nangungupahan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="housingType2" class="block text-sm font-medium text-gray-700">Mga Uri ng Pamamahay</label>
                                    <select id="housingType2" name="housingType2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled selected>-- Please select --</option>
                                        <option value="1">Yari sa Semento/ Concrete</option>
                                        <option value="2">Yari sa Semento at Kahoy /Semi-Concrete</option>
                                        <option value="3">Yari sa Kahoy o Magagaan na Materyales</option>
                                        <option value="4">Yari sa Karton, Papel o Plastik/ Salvaged house</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="kuryente" class="block text-sm font-medium text-gray-700">Kuryente</label>
                                    <select id="kuryente" name="kuryente" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled selected>-- Please select --</option>
                                        <option value="1">May kuryente</option>
                                        <option value="2">Walang kuryente</option>
                                        <option value="3">Nakikikabit</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="tubig" class="block text-sm font-medium text-gray-700">Tubig</label>
                                    <select id="tubig" name="tubig" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled selected>-- Please select --</option>
                                        <option value="1">Gripo (Tanza Water District, Subd. Water Provider)</option>
                                        <option value="2">Poso</option>
                                        <option value="3">Gripo de Kuryente/Sariling Tangke</option>
                                        <option value="4">Balon</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="palikuran" class="block text-sm font-medium text-gray-700">Palikuran</label>
                                    <select id="palikuran" name="palikuran" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled selected>-- Please select --</option>
                                        <option value="1">Inidoro (Water Sealed)</option>
                                        <option value="2">Balon (Antipolo type)</option>
                                        <option value="3">Walang Palikurang (No Latrine)</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                       <!-- <div class="flex items-center space-x-4 mt-4">
                             <button type="button" onclick="addRow();" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fa-solid fa-plus"></i> Add Row
                            </button> 
                            <button type="button" onclick="save_record();" class="px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 ml-auto">
                                <i class="fas fa-save"></i> Save Record
                            </button>
                        </div>-->
                        <input type="hidden" id="table_data" name="table_data">
                    </form>

                    <!-- <div id="table-container" class="mt-6"></div> -->
                </div>
            </div>
        </div>
    </div>


    {{-- PDF Previewer Section --}}
    <div class="w-full">
    <div class="mt-8 bg-white shadow sm:rounded-lg">
        <div class="p-6 w-full">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">PDF Previewer</h3>
            <div class="border rounded-lg overflow-hidden">
                <iframe src="{{ url($manuscript->file_path) }}" class="w-full h-96" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    </div>
    
    <script>
        // Initialize variables and table
        let tableData = [];
        let r_id = 0;
        let table;

        // Function to initialize Tabulator table
        function initializeTable() {
            table = new Tabulator("#table-container", {
                data: tableData,
                layout: "fitData",
                height: "400px",
                pagination: "local",
                paginationSize: 5,
                columns: [
                    { title: "Row No.", field: 'id', headerSort: false },
                    { title: "Surname", field: 'surname', editor: "input" },
                    { title: "Firstname", field: 'firstname', editor: "input" },
                    { title: "Middle Name", field: 'middlename', editor: "input" },
                    // { title: "Birthday", field: 'birthday', editor: "input" },
                    // { title: "Birthplace", field: 'birthplace', editor: "input" },
                    // { title: "Relasyon sa Pinuno ng Pamila", field: 'rspnp', editor: "input" },
                    // { title: "Trabaho/Grade Level/Out of School Youth", field: 'tglosy', editor: "input" },
                    // { title: "PWD/Senior/Solo Parent", field: 'pssp', editor: "input" },
                    // { title: "Date of 1st Dose", field: 'do1d', editor: "input" },
                    // { title: "Date of 2nd Dose", field: 'do2d', editor: "input" },
                    // { title: "Vaccine Brand", field: 'vcne', editor: "input" },
                    { title: "Actions", formatter: actionButtons }
                ],
            });
        }

        // Call the initializeTable function when the page loads
        document.addEventListener('DOMContentLoaded', (event) => {
            initializeTable();
        });

        function actionButtons(cell, formatterParams, onRendered) {
            return "<button type='button' onclick='deleteRow(" + cell.getRow().getIndex() + ")' class='px-2 py-1 bg-red-500 text-white rounded-md shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500'><i class='fa-solid fa-trash'></i></button>";
        }

        function addRow() {
            r_id++;
            table.addData([{ id: r_id, surname: '', firstname: '', middlename: '', birthday: '', birthplace: '', rspnp: '', tglosy: '', pssp: '', do1d: '', do2d: '', vcne: '' }]);
        }

        function deleteRow(rowIndex) {
            table.deleteRow(rowIndex);
        }

        function save_record() {
            let data = table.getData();
            document.getElementById('table_data').value = JSON.stringify(data);
            document.getElementById('recordForm').submit();
        }
    </script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/tabulator-tables@5.5.0/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</x-app-layout>

