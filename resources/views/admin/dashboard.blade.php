<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg ">
        <div class="w-full p-3 ">
        <div> <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">Dashboard</h2>
        </div>
            <div class="overflow-hidden sm:rounded-lg">
                <div class="text-gray-900 grid sm:grid-cols-3 grid-cols-1 gap-4">
                      <!-- New Cards for Manuscripts and Dropbox Counts -->
                      <div class="sm:col-span-3">
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-4 mb-4">
                            <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Total Research Manuscripts Sent</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalManuscripts }}</p>
                            <p class="text-sm text-gray-600 mt-1">As of {{ $currentMonth }} {{ $currentYear }}</p>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow p-4">
                            <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Total Research Reports Sent</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalDropboxes }}</p>
                            <p class="text-sm text-gray-600 mt-1">As of {{ $currentMonth }} {{ $currentYear }}</p>
                        </div>
                    </div>

                    <!-- Line Chart -->
                    <div class="sm:col-span-2">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Login Per Day</h3>
                        <button id="downloadLineChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="lineChart" class="w-full h-80"></canvas>
                    </div>

                    <!-- Pie Chart -->
                    <div class="sm:col-span-1">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Students Demographic per Course</h3>
                        <button id="downloadPieChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="coursePieChart" class="w-full h-80"></canvas>
                    </div>

                    <!-- Bar Chart -->
                    <div class="sm:col-span-3">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Progress Monitoring</h3>
                        <button id="downloadBarChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="barChart" class="!w-[100%] !h-[80%]"></canvas>
                    </div>

                    <!-- Pie Chart for Manuscripts per Course -->
                    <div class="sm:col-span-1">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Manuscripts per Course</h3>
                        <button id="downloadManuscriptPieChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="manuscriptPieChart" class="w-full h-80"></canvas>
                    </div>

                    <!-- Pie Chart for Dropbox per Course -->
                    <div class="sm:col-span-1">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Research Reports per Course</h3>
                        <button id="downloadDropboxPieChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="dropboxPieChart" class="w-full h-80"></canvas>
                    </div>
                    <div class="sm:col-span-1">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">Sub-Admin Sex Demographics</h3>
                        <button id="downloadsubAdminPieChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="subAdminPieChart" class="w-full h-80"></canvas>
                    </div>

                    <div class="sm:col-span-1">
                        <h3 class="text-xl font-semibold mb-2 text-[#1B651B]">User  Sex Demographics</h3>
                        <button id="downloaduserPieChart" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded" title="Download Chart as Image"><i class="fas fa-download"></i></button>
                        <canvas id="userPieChart" class="w-full h-80"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Line Chart
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: @json(array_keys($subAdminData + $userData)),
            datasets: [
                {
                    label: 'Sub-Admin',
                    data: @json(array_values($subAdminData)),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                },
                {
                    label: 'User',
                    data: @json(array_values($userData)),
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: true
                }
            ]
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
            }
        }
    });

    // Pie Chart for Course Population
    const ctxPie = document.getElementById('coursePieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: @json($courses),
            datasets: [{
                label: 'Course Population',
                data: @json($populations),
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
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed >= 0) {
                                label += new Intl.NumberFormat().format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Bar Chart for Dropbox Status
    const ctxBar = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: @json($dropboxStatuses),
            datasets: [{
                label: 'Dropbox Status Count',
                data: @json($dropboxCounts),
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
            }
        }
    });

    // Pie Chart for Manuscripts per Course
    const ctxManuscriptPie = document.getElementById('manuscriptPieChart').getContext('2d');
    const manuscriptPieChart = new Chart(ctxManuscriptPie, {
        type: 'pie',
        data: {
            labels: @json($manuscriptCourses),
            datasets: [{
                label: 'Manuscript Count per Course',
                data: @json($manuscriptCounts),
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
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed >= 0) {
                                label += new Intl.NumberFormat().format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Pie Chart for Dropbox per Course
    const ctxDropBoxPie = document.getElementById('dropboxPieChart').getContext('2d');
    const dropboxPieChart = new Chart(ctxDropBoxPie, {
        type: 'pie',
        data: {
            labels: @json(array_keys($researchDropboxData)), // Ensure this matches the labels
            datasets: [{
                label: 'Dropbox Count per Course',
                data: @json(array_values($researchDropboxData)), // Ensure this matches the data
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
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed >= 0) {
                                label += new Intl.NumberFormat().format(context.parsed);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
    <script>
        // Download Chart as Image
        function downloadChartAsImage(chart, fileName) {
            const link = document.createElement('a');
            link.href = chart.toBase64Image();
            link.download = fileName;
            link.click();
        }

        document.getElementById('downloadLineChart').addEventListener('click', function() {
            downloadChartAsImage(lineChart, 'line-chart.png');
        });

        document.getElementById('downloadPieChart').addEventListener('click', function() {
            downloadChartAsImage(pieChart, 'course-pie-chart.png');
        });

        document.getElementById('downloadBarChart').addEventListener('click', function() {
            downloadChartAsImage(barChart, 'dropbox-bar-chart.png');
        });

        document.getElementById('downloadManuscriptPieChart').addEventListener('click', function() {
            downloadChartAsImage(manuscriptPieChart, 'manuscript-pie-chart.png');
        });

        document.getElementById('downloadDropboxPieChart').addEventListener('click', function() {
            downloadChartAsImage(dropboxPieChart, 'dropbox-pie-chart.png');
        });
        document.getElementById('downloadsubAdminPieChart').addEventListener('click', function() {
            downloadChartAsImage(dropboxPieChart, 'sub-admin-sex-pie-chart.png');
        });
        document.getElementById('downloadusePieChart').addEventListener('click', function() {
            downloadChartAsImage(dropboxPieChart, 'user-sex-pie-chart.png');
        });
    </script>
     <script>
        // Sub-admin demographics pie chart
        var ctx = document.getElementById('subAdminPieChart').getContext('2d');
        var subAdminData = @json($combinedDemographics['sub-admin']);
        var subAdminLabels = subAdminData.map(data => data.sex);
        var subAdminValues = subAdminData.map(data => data.total);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: subAdminLabels,
                datasets: [{
                    data: subAdminValues,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (context.parsed !== null) {
                                    label += ': ' + context.parsed + ' users';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // User demographics pie chart
        var ctx2 = document.getElementById('userPieChart').getContext('2d');
        var userData = @json($combinedDemographics['user']);
        var userLabels = userData.map(data => data.sex);
        var userValues = userData.map(data => data.total);

        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: userLabels,
                datasets: [{
                    data: userValues,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (context.parsed !== null) {
                                    label += ': ' + context.parsed + ' users';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@section('title', 'Admin Dashboard')
</x-app-layout>
