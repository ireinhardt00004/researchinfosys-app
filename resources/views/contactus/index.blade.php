<x-app-layout>
    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                    <!-- Header Title -->
                    <div class="mb-4">
                        <h1 class="uppercase text-3xl font-bold text-[#1b651b]">Contact Us</h1>
                    </div>
                    <div>
                        <button class="bg-blue-500 text-xl p-2 m-4 rounded float-right text-white w-[120px]" onclick="exportTableToPDF()" title="Download Table as PDF">
                            <i class="fas fa-file-pdf"></i> Export
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
                paginationSize: 10,
                height: "100%",
                rowFormatter: function (row) {
                    row.getElement().style.height = "60px";
                },
                columns: [
                    { title: "Full Name", field: "fullname", minWidth: 120 },
                    { title: "Email Address", field: "email", minWidth: 120 },
                    { title: "Subject", field: "subject", minWidth: 120 },
                    { title: "Concern", field: "concern", minWidth: 120 },
                    { title: "Timestamp", field: "timestamp", minWidth: 120 },
                    { title: "Action", field: "actions", formatter: "html", minWidth: 200 },
                ],
            });

            // Search Function
            window.search_btn = function() {
                var searchValue = document.getElementById("search-input").value;
                table.setFilter("fullname", "like", searchValue);
            };

            // View Contact Us Details
            window.viewContactUs = function(user_id) {
                fetch(`/contact-us/${user_id}`)
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Contact Details',
                            html: `
                                <p><strong>Full Name:</strong> ${data.fullname}</p>
                                <p><strong>Email Address:</strong> ${data.email}</p>
                                <p><strong>Subject:</strong> ${data.subject}</p>
                                <p><strong>Concern:</strong> ${data.concern}</p>
                                <p><strong>Timestamp:</strong> ${data.timestamp}</p>
                            `,
                            icon: 'info',
                            confirmButtonText: 'Close'
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Failed to fetch contact details', 'error');
                    });
            };

            // Reply to Contact Us
            window.replyContactUs = function(user_id) {
                Swal.fire({
                    title: 'Reply to Concern',
                    input: 'textarea',
                    inputPlaceholder: 'Type your reply here...',
                    inputAttributes: {
                        'aria-label': 'Type your reply here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Send Reply',
                    cancelButtonText: 'Cancel',
                    preConfirm: (reply) => {
                        if (!reply) {
                            Swal.showValidationMessage('Please enter your reply.');
                        }
                        return fetch(`/contact-us/reply/${user_id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ reply })
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        }).then(data => {
                            if (data.success) {
                                Swal.fire('Sent!', 'Your reply has been sent.', 'success');
                            } else {
                                Swal.fire('Error!', 'Failed to send the reply.', 'error');
                            }
                        }).catch(error => {
                            Swal.fire('Error!', 'There was an error sending the reply.', 'error');
                        });
                    }
                });
            };

            // Delete Contact Us Entry
            window.deleteContactUs = function(user_id) {
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure you want to delete this concern?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/contact-us/${user_id}`, {
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
                                text: 'The concern has been deleted.'
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

        function exportTableToPDF() {
            alert("TBA")
        }
    </script>
    @section('title','Contact Us')
</x-app-layout>
