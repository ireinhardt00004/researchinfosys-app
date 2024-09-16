<x-app-layout>
    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                   
                    <!-- Header Title -->
                    <div class="mb-4">
                        <h1 class="uppercase text-3xl font-bold text-[#1b651b]">Sub Admin Accounts List</h1>
                    </div>
                    <div>
                    <button class="bg-blue-500 text-xl p-2 m-4 rounded float-right text-white w-[120px]" onclick="exportTableToPDF()" title="Download Table as PDF">
                            <i class="fas fa-file-pdf"></i>  Export 
                        </button>
                        <button class="bg-green-500 text-xl p-2 m-4 rounded float-right text-white w-[200px]" onclick="registerSubAdmin()" title="Download Table as PDF">
                            <i class="fas fa-plus"></i><i class="fas fa-user"></i> Register Staff
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
                { title: "Faculty Number", field: "uid", minWidth: 150 },
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
                url = `{{ url('/admin/subdelete-user/') }}/${user_id}`;
                swalHtml = `
                    <input type="password" id="admin-password" class="swal2-input" placeholder="Enter admin password">
                `;
            } else if (mod_type === 3) {
                actionText = 'Edit Credentials';
                confirmText = 'Are you sure you want to change the user credentials?';
                url = `{{ url('/admin/subedit-credentials/') }}/${user_id}`;
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
                            return response.json().then(error => {
                                Swal.fire('Error!', `There was an error processing your request: ${error.message}`, 'error');
                            });
                        }
                        return response.json();
                    }).then(data => {
                        Swal.fire({
                            title: actionText === 'Delete' ? 'User Deleted!' : 'Credentials Updated!',
                            icon: 'success',
                            text: actionText === 'Delete' ? 'The user account has been deleted.' : 'The user credentials have been updated.'
                        }).then(() => {
                            window.location.reload();
                        });
                    }).catch(error => {
                        console.error('Fetch error:', error);
                        Swal.fire('Error!', 'There was an error processing your request.', 'error');
                    });
                }
            });
        };

        window.registerSubAdmin = function() {
            Swal.fire({
                title: 'Register Staff',
                html: `
                    <style>
                        .swal2-input, .swal2-select {
                            border-radius: 5px;
                            border: 1px solid #d1d5db;
                            padding: 8px 12px;
                            margin-bottom: 16px;
                            font-size: 16px;
                            box-sizing: border-box;
                            width: calc(100% - 24px);
                            display: block;
                        }
                        .swal2-select {
                            height: 40px;
                        }
                        .swal2-input:focus, .swal2-select:focus {
                            border-color: #34d399;
                            outline: none;
                            box-shadow: 0 0 0 2px rgba(72, 187, 120, 0.2);
                        }
                        .swal2-container {
                            font-family: Arial, sans-serif;
                        }
                        .swal2-title {
                            font-size: 20px;
                            font-weight: bold;
                        }
                        .swal2-html-container {
                            margin-top: 8px;
                        }
                        .swal2-confirm-button {
                            background-color: #28a745 !important;
                            border-color: #28a745 !important;
                            color: white !important;
                            padding: 8px 16px;
                            font-size: 16px;
                        }
                        .swal2-cancel-button {
                            background-color: #6c757d !important;
                            border-color: #6c757d !important;
                            color: white !important;
                            padding: 8px 16px;
                            font-size: 16px;
                        }
                    </style>
                    <div class="p-2 text-base space-y-5">
                    <div class="grid grid-cols-1 gap-2 text-left">
                        <label for="">Faculty Number</label>
                        <input class="swal2-input !m-0" type="text" name="studnum" id="studnum"  placeholder="Faculty Number "/>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="grid grid-cols-1 gap-2 text-left">
                            <label for="">Last Name</label>
                            <input class="swal2-input !m-0" type="text" name="lname" id="lname" placeholder="Last name" required/>
                        </div>
                        <div class="grid grid-cols-1 gap-2 text-left">
                            <label for="">First Name</label>
                            <input class="swal2-input !m-0" type="text" name="fname" id="fname" placeholder="Fist name" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 text-left">
                        <label for="">Middle Name</label>
                        <input class="swal2-input !m-0" type="text" name="middlename" id="middlename" placeholder="Middle name(optional)" />
                    </div>
                    <div class="grid grid-cols-2 gap-2 ">
                        <div class="grid grid-cols-1 gap-2 text-left">
                            <label for="">Sex</label>
                            <select class="swal2-select !m-0" id="sex" name="sex"  required>
                                <option value="" selected disabled>Select Sex</option>
                                <option value="Male">Male </option>
                                <option value="Female">Female </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-2 text-left">
                            <label for="">Program</label>
                            <select class="swal2-select !m-0" id="courseID" name="courseID" required>
                                <option value="" selected disabled>Select Course</option>
                                <option value="BSIT">Bachelor of Science in Information Technology</option>
                                <option value="BSBA">Bachelor of Science in Business Administration</option>
                                <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                                <option value="BSP">Bachelor of Science in Psychology</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 text-left">
                        <label for="">CvSU Email Address</label>
                        <input class="swal2-input !m-0" type="email" name="email" id="email" placeholder="Email" required/>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-left">
                        <div class="grid grid-cols-1 gap-2">
                            <label for="">Password</label>
                            <input class="swal2-input !m-0" type="password" name="password" id="password" placeholder="Password" required/>
                        </div>
                        <div class="grid grid-cols-1 gap-2 text-left">
                            <label for="">Confirm Password</label>
                            <input class="swal2-input !m-0" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confrim Password" required/>
                        </div>
                    </div>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Register',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const studnum = Swal.getPopup().querySelector('#studnum').value;
                    const lname = Swal.getPopup().querySelector('#lname').value;
                    const fname = Swal.getPopup().querySelector('#fname').value;
                    const middlename = Swal.getPopup().querySelector('#middlename').value;
                    const sex = Swal.getPopup().querySelector('#sex').value;
                    const courseID = Swal.getPopup().querySelector('#courseID').value;
                    const email = Swal.getPopup().querySelector('#email').value;
                    const password = Swal.getPopup().querySelector('#password').value;
                    const passwordConfirmation = Swal.getPopup().querySelector('#password_confirmation').value;

                    if (!lname || !fname || !sex || !courseID || !email || !password || password !== passwordConfirmation) {
                        Swal.showValidationMessage(`Please fill out all fields correctly.`);
                    }
                    return {
                        studnum,
                        lname,
                        fname,
                        middlename,
                        sex,
                        courseID,
                        email,
                        password,
                        password_confirmation: passwordConfirmation
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/admin/register-staff', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(result.value)
                    }).then(response => {
                        if (!response.ok) {
                            return response.json().then(error => {
                                Swal.fire('Error!', `There was an error registering the staff: ${error.message}`, 'error');
                                console.log(error)
                            });
                        }
                        return response.json();
                    }).then(data => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'The staff has been registered successfully.',
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    }).catch(error => {
                        console.error('Fetch error:', error);
                        Swal.fire('Error!', 'There was an error registering the staff.', 'error');
                    });
                }
            });
        };
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script>
function exportTableToPDF() {
    const tableContainer = document.getElementById('table-container');
    const actionColumnHeader = tableContainer.querySelector('.tabulator-col[title="Action"]');
    const actionColumnCells = tableContainer.querySelectorAll('.tabulator-cell[data-field="actions"]');
    // Hide the Action column header and cells
    if (actionColumnHeader) actionColumnHeader.style.display = 'none';
    actionColumnCells.forEach(cell => cell.style.display = 'none');
    html2canvas(tableContainer, {
        scale: 5  // Adjust the scale for higher resolution
    }).then(canvas => {
        const pdf = new jsPDF('p', 'mm', 'a4'); 
        const imgData = canvas.toDataURL('image/png');
        pdf.addImage(imgData, 'PNG', 10, 10, 190, 0); 
        pdf.save('SubAdminAccountsList.pdf');
        if (actionColumnHeader) actionColumnHeader.style.display = '';
        actionColumnCells.forEach(cell => cell.style.display = '');
    }).catch(error => {
        console.error('Error exporting table to PDF:', error);
        if (actionColumnHeader) actionColumnHeader.style.display = '';
        actionColumnCells.forEach(cell => cell.style.display = '');
    });
}
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

    @section('title', 'Sub Admin Accounts List')
</x-app-layout>
