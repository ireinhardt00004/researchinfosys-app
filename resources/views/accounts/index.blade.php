<x-app-layout>
    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                   
                      <!-- Header Title -->
                    <div class="mb-4">
                        <h1 class="uppercase text-3xl font-bold text-[#1b651b]">Validate Account</h1>
                    </div>
                    <!-- <div>
                        <button class="bg-blue-500 text-xl p-2 m-4 rounded float-right text-white w-[120px]" onclick="exportTableToPDF()" title="Download Table as PDF">
                            <i class="fas fa-file-pdf"></i>  Export 
                        </button>
                    </div> -->
                    <div class="shadow search-btn d-flex p-2 rounded" style="background-color:rgb(255,255,255,0.4);">
                        <input autofocus onkeyup="search_btn();" onkeydown="if (event.keyCode === 13) search_btn();" type="text" id="search-input" autocomplete="off" placeholder="Search name...">
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
              paginationSize: 4,
              height: "100%",
              rowFormatter: function (row) {
                  row.getElement().style.height = "60px";
              },
              columns: [
                  { title: "Student Number", field: "uid", minWidth: 250 },
                  { title: "Fullname", field: "fullname", minWidth: 250 },
                  { title: "Email", field: "email", minWidth: 120 },
                  { title: "Course", field: "courseID", minWidth: 120 },
                  { title: "Action", field: "actions", formatter: "html", minWidth: 200 },
              ],
          });
      
          // Search Function
          window.search_btn = function() {
              var searchValue = document.getElementById("search-input").value;
              table.setFilter("fullname", "like", searchValue);
          };
          
          window.mod_request = function(mod_type, user_id) {
          let actionText = mod_type === 2 ? 'Decline' : 'Make Verified';
          let confirmText = mod_type === 2 ? 'Are you sure you want to decline this request?' : 'Are you sure you want to verify this account?';
          let url = mod_type === 2 ? `{{ url('/admin/verify-user/decline/') }}/${user_id}` : `{{ url('/admin/verify-user/approve/') }}/${user_id}`;
          
          Swal.fire({
              title: 'Confirmation',
              text: confirmText,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: mod_type === 2 ? '#dc3545' : '#28a745',
              cancelButtonColor: '#6c757d',
              confirmButtonText: actionText,
              cancelButtonText: 'Cancel'
          }).then((result) => {
              if (result.isConfirmed) {
                  fetch(url, {
                      method: 'POST',
                      headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      }
                  }).then(response => {
                      if (!response.ok) {
                          Swal.fire('Error!', 'There was an error processing your request.', 'error');
                          return response.text();
                      }
                      Swal.fire({
                          title: mod_type === 2 ? 'Request Declined!' : 'Request Approved!',
                          icon: mod_type === 2 ? 'error' : 'success',
                          text: mod_type === 2 ? 'The request has been declined.' : 'The request has been approved.'
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
    function exportTableToPDF(){
        alert("TBA")
    }
</script>
@section('title','Validate Account')
</x-app-layout>
