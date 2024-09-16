<x-app-layout>
    <div class="py-12 w-full grow bg-gray-100 rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-8 text-gray-900 h-full">
                    <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">Data Management</h2>
                    <!-- Year Dropdown -->
                        <form id="yearForm" class="flex items-center">
                            <label for="year" class="mr-2 text-lg font-semibold text-gray-600">Select Year:</label>
                            <select id="year" name="year" class="border-gray-300 w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-2xl">
                                @for ($i = 2021; $i <= 2031; $i++)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>
                    <!-- Manuscripts Line Graph -->
                    <div class="mb-10">
                        <h2 class="text-lg font-semibold text-gray-700">Approved Manuscripts per Month</h2>
                        <button id="downloadManuscripts" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Download Manuscripts Chart</button>
                        <canvas id="manuscriptsChart" class="mt-4"></canvas>    
                    </div>
                    <!-- Dropbox Line Graph -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Approved Research Report per Month</h2>
                        <button id="downloadDropbox" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Download Chart</button>
                        <canvas id="dropboxChart" class="mt-4"></canvas>       
                    </div>
                    <br>
                    <!-- Livewire Search Component -->
                    <div class="w-full m-3">
                        <h2 class="text-2xl font-bold m-4">Find Approved Manuscript & Research Reports</h2>
                            @livewire('approved-manuscript-search')
                        </div>     
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Month labels
        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        // Manuscripts Data
        var manuscriptsData = Array(12).fill(0); 
        @foreach($manuscriptsData as $data)
            manuscriptsData[{{ $data->month - 1 }}] = {{ $data->total }};
        @endforeach
        // Dropbox Data
        var dropboxData = Array(12).fill(0); 
        @foreach($dropboxData as $data)
            dropboxData[{{ $data->month - 1 }}] = {{ $data->total }};
        @endforeach

        // Manuscripts Line Graph
        var ctx1 = document.getElementById('manuscriptsChart').getContext('2d');
        var manuscriptsChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Manuscripts per Month',
                    data: manuscriptsData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#4B5563', // Gray-600
                        },
                        grid: {
                            color: '#E5E7EB', // Gray-200
                        }
                    },
                    x: {
                        ticks: {
                            color: '#4B5563', // Gray-600
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Dropbox Line Graph
        var ctx2 = document.getElementById('dropboxChart').getContext('2d');
        var dropboxChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Dropbox per Month',
                    data: dropboxData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#4B5563', 
                        },
                        grid: {
                            color: '#E5E7EB', 
                        }
                    },
                    x: {
                        ticks: {
                            color: '#4B5563', 
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Handle year change
        document.getElementById('year').addEventListener('change', function() {
            document.getElementById('yearForm').submit();
        });

        // Download chart as image
        document.getElementById('downloadManuscripts').addEventListener('click', function() {
            var link = document.createElement('a');
            link.href = document.getElementById('manuscriptsChart').toDataURL('image/png');
            link.download = 'manuscripts_chart.png';
            link.click();
        });

        document.getElementById('downloadDropbox').addEventListener('click', function() {
            var link = document.createElement('a');
            link.href = document.getElementById('dropboxChart').toDataURL('image/png');
            link.download = 'dropbox_chart.png';
            link.click();
        });
    </script>
        @section('title', 'Data Management')
</x-app-layout>
