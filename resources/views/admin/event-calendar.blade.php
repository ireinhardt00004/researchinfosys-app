<x-app-layout>
    <link href="https://unpkg.com/fullcalendar@5.10.0/main.min.css" rel="stylesheet">
    <script src="https://unpkg.com/fullcalendar@5.10.0/main.min.js"></script>

    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-screen">
            <h2 class="text-2xl font-bold m-3 uppercase text-[#1B651B]">Calendar</h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                    <div class="">
                        <div class="flex items-end">
                            @auth
                                @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('sub-admin'))
                                    <button id="create-event-btn" class="rounded bg-[#1b651b] text-white p-3 m-4">
                                        <i class="fas fa-calendar"></i> Create Event
                                    </button>
                                @endif
                            @endauth
                        </div><br>
                        <div id="brgy-calendar"></div>
                        <div class="my-5">
                            <h5 class="text-2xl font-semibold">Total Events</h5>
                            <ul class="my-5 space-y-5 list-image-[url({{ asset('img/pin-svgrepo-com.svg') }})]">
                                @foreach($events as $event)
                                    <li class="mb-2 bg-[#1B651B] text-white p-2 rounded-lg space-y-3 drop-shadow-lg">
                                        <h6 class="flex gap-3">
                                            <strong>{{ $event->title }}</strong> - <p>{{ $event->type }}</p>
                                            <button title="Delete Event" class="btn btn-danger btn-sm" onclick="deleteEvent('{{ $event->id }}')">
                                                <i class="fas fa-trash text-red-600"></i>
                                            </button>
                                        </h6>
                                        <p>{{ \Carbon\Carbon::parse($event->start_datetime)->format('F d, Y h:i A') }} until {{ \Carbon\Carbon::parse($event->end_datetime)->format('F d, Y h:i A') }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Responsive styling for the SweetAlert modal */
        @media (max-width: 600px) {
            .swal2-popup {
                width: 90% !important;
                font-size: 14px !important;
            }
            .swal2-input,
            .swal2-textarea,
            .swal2-select {
                width: 100% !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('brgy-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                height: 450,
                initialView: 'dayGridMonth',
                events: @json($calendarEvents),
                eventClick: function(info) {
                    const event = info.event;
                    Swal.fire({
                        title: event.title,
                        html: `
                            <p><strong>Description:</strong> ${event.extendedProps.description}</p>
                            <p><strong>Type:</strong> ${event.extendedProps.type}</p>
                            <p><strong>Start:</strong> ${event.start.toLocaleString()}</p>
                            <p><strong>End:</strong> ${event.end ? event.end.toLocaleString() : 'N/A'}</p>
                        `,
                        showCloseButton: true,
                        showConfirmButton: false,
                        customClass: 'responsive-modal'
                    });
                }
            });
            calendar.render();
        });

        document.getElementById('create-event-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Create Event',
                html: `
                    <input id="title" class="swal2-input" placeholder="Title">
                    <textarea id="description" class="swal2-textarea" placeholder="Description"></textarea>
                    <select id="type" class="swal2-select">
                        <option value="Regular Holiday">Regular Holiday</option>
                        <option value="Special Holiday">Special Holiday</option>
                        <option value="Others">Others</option>
                    </select>
                    <input id="start_datetime" class="swal2-input" type="datetime-local">
                    <input id="end_datetime" class="swal2-input" type="datetime-local">
                    <div style="text-align: left; margin-top: 10px;">
                        <input type="checkbox" id="notify_residents">
                        <label for="notify_residents">Notify users via email too?</label>
                    </div>
                `,
                confirmButtonText: 'Create',
                showCancelButton: true,
                customClass: 'responsive-modal',
                preConfirm: () => {
                    const title = document.getElementById('title').value;
                    const description = document.getElementById('description').value;
                    const type = document.getElementById('type').value;
                    const start_datetime = document.getElementById('start_datetime').value;
                    const end_datetime = document.getElementById('end_datetime').value;
                    const notify_residents = document.getElementById('notify_residents').checked;

                    return { title, description, type, start_datetime, end_datetime, notify_residents };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we create the event and send notifications.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('events.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(result.value)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'There was an error processing your request.', 'error');
                    });
                }
            });
        });

        function deleteEvent(eventId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/events/delete') }}/${eventId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }).catch(error => {
                        Swal.fire('Error!', 'Failed to delete event. Please try again later.', 'error');
                    });
                }
            });
        }
    </script>

@section('title','Event Calendar')
</x-app-layout>
