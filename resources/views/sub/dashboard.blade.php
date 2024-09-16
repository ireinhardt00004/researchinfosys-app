<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dropbox Status') }}
        </h2>
    </x-slot>

    <div class="py-12 w-full bg-gray-100 rounded-lg drop-shadow-lg">
        <div class="w-full p-6">
            <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">Dashboard</h2>
            <div class="overflow-hidden sm:rounded-lg">
                <div class="text-gray-900 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card for Total Manuscripts -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Total Manuscripts</h3>
                        <p class="text-3xl font-bold">{{ $totalManuscripts }}</p>
                        <p class="text-sm text-gray-600 mt-1">As of {{ $currentMonth }} {{ $currentYear }}</p>
                    </div>

                    <!-- Card for Total Dropbox Count -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Total Dropboxes</h3>
                        <p class="text-3xl font-bold">{{ $totalDropboxes }}</p>
                        <p class="text-sm text-gray-600 mt-1">As of {{ $currentMonth }} {{ $currentYear }}</p>
                    </div>

                    <!-- Bar Chart for Dropbox Status -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Dropbox Status</h3>
                        <button id="downloadBarChart" title="Download Chart" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-150" title="Download Chart as Image">
                            <i class="fas fa-download"></i> 
                        </button>
                        <canvas id="barChart" class="w-full h-80 mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart for Dropbox Status
        const ctxBar = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($statuses),
                datasets: [{
                    label: 'Dropbox Status Count',
                    data: @json($counts),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat().format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Download Button Functionality
        document.getElementById('downloadBarChart').addEventListener('click', function() {
            const link = document.createElement('a');
            link.href = ctxBar.canvas.toDataURL('image/png');
            link.download = 'bar_chart.png';
            link.click();
        });
    </script>
    @section('title','Dashboard')
</x-app-layout>
