<x-app-layout>
    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white w-full overflow-x-auto shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                    <div class="mb-4">
                        <h1 class="uppercase text-3xl font-bold text-[#1b651b]">User List</h1>
                    </div>
                    <div>
                        <button class="bg-blue-500 text-xl py-2 px-3 m-4 rounded float-right text-nowrap text-white " onclick="exportTableToPDF()" title="Download Table as PDF">
                            <i class="fas fa-file-pdf"></i> Export as PDF
                        </button>
                    </div>
                    <div class="shadow search-btn d-flex p-2 rounded" style="background-color:rgb(255,255,255,0.4);">
                        <input autofocus onkeyup="search_btn();" onkeydown="if (event.keyCode === 13) search_btn();" type="text" id="search-input" autocomplete="off" placeholder="Search name...">
                    </div>
                    <div id="table-container" style="font-size:16px;" class="shadow rounded"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

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
                    { title: "Roles", field: "roles", minWidth: 60 },
                    { title: "Student Number", field: "uid", minWidth: 100 },
                    { title: "Fullname", field: "fullname", minWidth: 150 },
                    { title: "Email", field: "email", minWidth: 200 },
                    { title: "Course", field: "courseID", minWidth: 70 },
                    { title: "Action", field: "actions", formatter: "html", minWidth: 40 },
                ],
            });

            // Search Function
            window.search_btn = function() {
                var searchValue = document.getElementById("search-input").value;
                table.setFilter("fullname", "like", searchValue);
            };
            
            window.mod_request = function(mod_type, user_id) {
                let actionText, confirmText, url, swalHtml;
                if (mod_type === 2) {
                    actionText = 'Delete';
                    confirmText = 'Are you sure you want to delete this user account?';
                    url = `{{ url('/admin/delete-user/') }}/${user_id}`;
                    swalHtml = `
                        <input type="password" id="admin-password" class="swal2-input" placeholder="Enter admin password">
                    `;
                } else if (mod_type === 3) {
                    actionText = 'Edit Credentials';
                    confirmText = 'Are you sure you want to change the user credentials?';
                    url = `{{ url('/admin/edit-credentials/') }}/${user_id}`;
                    swalHtml = `
                        <input type="password" id="admin-password" class="swal2-input" placeholder="Enter admin password">
                        <input type="password" id="new-password" class="swal2-input" placeholder="Enter new password">
                        <input type="password" id="confirm-password" class="swal2-input" placeholder="Confirm new password">
                    `;
                }

                Swal.fire({
                    title: 'Confirmation',
                    text: confirmText,
                    html: swalHtml,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: mod_type === 2 ? '#dc3545' : '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: actionText,
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'swal2-custom-popup',
                        confirmButton: 'swal2-confirm-button',
                        cancelButton: 'swal2-cancel-button'
                    },
                    preConfirm: () => {
                        const adminPassword = Swal.getPopup().querySelector('#admin-password').value;
                        const newPassword = Swal.getPopup().querySelector('#new-password') ? Swal.getPopup().querySelector('#new-password').value : null;
                        const confirmPassword = Swal.getPopup().querySelector('#confirm-password') ? Swal.getPopup().querySelector('#confirm-password').value : null;
                        if (!adminPassword || (mod_type === 3 && (!newPassword || newPassword !== confirmPassword))) {
                            Swal.showValidationMessage(`Please enter all required fields correctly`);
                        }
                        return { adminPassword, newPassword };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const { adminPassword, newPassword } = result.value;
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                admin_password: adminPassword,
                                new_password: newPassword,
                                new_password_confirmation: newPassword
                            })
                        }).then(response => {
                            if (!response.ok) {
                                Swal.fire('Error!', 'There was an error processing your request.', 'error');
                                return response.json();
                            }
                            Swal.fire({
                                title: actionText === 'Delete' ? 'User Deleted!' : 'Credentials Updated!',
                                icon: 'success',
                                text: actionText === 'Delete' ? 'The user account has been deleted.' : 'The user credentials have been updated.'
                            }).then(() => {
                                window.location.reload();
                            });
                            return response.json();
                        }).catch(error => {
                            console.error('Fetch error:', error);
                            Swal.fire('Error!', 'There was an error processing your request.', 'error');
                        });
                    }
                });
            };
            // Function to generate PDF
            window.exportTableToPDF = function() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                doc.text("User List", 10, 10);

                // Extract data from Tabulator table
                var tableData = table.getData();
                const columns = ["Roles", "Student Number", "Fullname", "Email", "Course"];
                const tableDataFormatted = tableData.map(row => [
                    row.roles,
                    row.uid,
                    row.fullname,
                    row.email,
                    row.courseID,
                ]);
                doc.autoTable({
                    head: [columns],
                    body: tableDataFormatted,
                    startY: 20
                });
                doc.save('user-list.pdf');
            };
        });
    </script>
    <style>
        .swal2-custom-popup {
            font-size: 16px;
            padding: 20px;
        }
        .swal2-confirm-button {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .swal2-cancel-button {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }
    </style>
    @section('title', 'User List')
</x-app-layout>
