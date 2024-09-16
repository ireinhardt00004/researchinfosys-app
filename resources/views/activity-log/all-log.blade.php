<x-app-layout>
    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                   
                      <!-- Header Title -->
                    <div class="mb-4">
                        <h1 class="uppercase text-3xl font-bold text-[#1b651b]">All Activity Log</h1>
                    </div>
                    <div>
                        <button class="bg-blue-500 text-xl p-2 m-4 rounded float-right text-white w-[120px]" onclick="exportTableToExcel()" title="Download Table as PDF">
                            <i class="fas fa-file-pdf"></i>  Export as Excel
                        </button>
                    </div>
                    <div class="shadow search-btn d-flex p-2 rounded" style="background-color:rgb(255,255,255,0.4);">
                        <input autofocus onkeyup="search_btn();" onkeydown="if (event.keyCode === 13) search_btn();" type="text" id="search-input" autocomplete="off" placeholder="Search activity...">
                    </div>
                    <div id="table-container" style="font-size:16px;" class="shadow rounded"></div>
                
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
          // Data Preparation
          var tableData = @json($users);
      
          // Initialize Tabulator
          var table = new Tabulator("#table-container", {
              data: tableData,
              placeholder: 'Empty Data',
              layout: "fitColumns",
              pagination: "local",
              paginationSize: 10,
              height: "100%",
              rowFormatter: function (row) {
                  row.getElement().style.height = "60px";
              },
              columns: [
                { title: "Role", field: "roles", minWidth: 60 },
                { title: "Name", field: "fullname", minWidth: 60 },
                  { title: "Activity", field: "activity", minWidth: 160 },
                  { title: "Timestamp", field: "timestamp", minWidth: 120 },
                  { title: "Action", field: "actions", formatter: "html", minWidth: 60 },
              ],
          });
      
          // Search Function
          window.search_btn = function() {
              var searchValue = document.getElementById("search-input").value;
              table.setFilter("activity", "like", searchValue);
          };
          
           window.deleteActivity = function(user_id) {
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure you want to delete this activity log?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/activity-log/${user_id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (!response.ok) {
                                Swal.fire('Error!', 'There was an error processing your request.', 'error');
                                return response.text();
                            }
                            Swal.fire({
                                title: 'Deleted!',
                                icon: 'success',
                                text: 'The activity log has been deleted.'
                            }).then(() => {
                                window.location.reload(); 
                            });
                            return response.text();
                        }).then(data => {
                            console.log('Response data:', data);
                        }).catch(error => {
                            console.log('Fetch error:', error);
                            Swal.fire('Error!', 'There was an error processing your request.', 'error');
                        });
                    }
                });
            };
        });
</script>
<script>
    function exportTableToExcel() {
        window.location.href = '{{ route('export.activity.log') }}';
    }
</script>
@section('title','All Logs')
</x-app-layout>
