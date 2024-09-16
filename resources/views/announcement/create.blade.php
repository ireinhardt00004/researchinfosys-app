<x-app-layout>
<div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
    <div>
        <a href="{{ route('newsfeed.index') }}">
        <button class="rounded bg-slate-500 text-white p-2 mb-2 ml-4"><i class="fas fa-reply"></i>  Return to News and Announcement</button>
        </a>
    </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <div class="container mx-auto mb-4">
                        <form id="announcement-form" method="POST" enctype="multipart/form-data" action="{{ route('announcements.store') }}">
                            @csrf
                            <div class="flex flex-col lg:flex-row">
                                <div class="text-center lg:w-1/3 mb-4 lg:mb-0">
                                    <img id="prev-img-event" class="rounded-lg w-full h-64 object-cover" src="{{ asset('sys_logo/Lenny.jfif') }}" alt="Preview Image">
                                    <label for="imageFilez" class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600">
                                        <input onchange="sel_img('prev-img-event');" class="hidden" type="file" id="imageFilez" name="imageFilez" accept="image/gif, image/png, image/jpeg" required>
                                        Change Image
                                    </label>
                                </div>
                                <div class="lg:w-2/3">
                                    <div class="mb-4">
                                        <label for="event-title" class="block text-gray-700">Title:</label>
                                        <input id="event-title" class="w-full mt-1 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" type="text" name="event-title" placeholder="My title.." autocomplete="off" value="{{ old('event-title') }}">
                                        @error('event-title')
                                            <div class="text-red-500 mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <textarea id="markdown-editor-container" class="w-full h-64 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" name="event-content" autocomplete="off" placeholder="Content..">{{ old('event-content') }}</textarea>
                                        @error('event-content')
                                            <div class="text-red-500 mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600" type="submit">Create Announcement</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Additional styles for markdown editor */
        .simplemde-container {
            border: 1px solid #d1d5db; /* Tailwind border-gray-300 */
            border-radius: 0.375rem; /* Tailwind rounded */
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <script>
        function sel_img(eid) {
            var file_path = document.getElementById("imageFilez");
            var preview = document.getElementById(eid);

            var f_ext = file_path.value.split('.').pop().toLowerCase();
            if (['jpg', 'gif', 'png', 'jpeg'].includes(f_ext)) {
                preview.src = URL.createObjectURL(file_path.files[0]);
                preview.classList.remove('cstm-hidden');
            }
        }

        var simplemde = new SimpleMDE({
            element: document.getElementById("markdown-editor-container"),
            spellChecker: false,
            toolbar: [
                "bold",
                "italic",
                "heading",
                "|",
                "unordered-list",
                "ordered-list",
                "|",
                "link",
                "image",
                "|",
                "preview",
            ],
        });

        document.getElementById('announcement-form').addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch('{{ route('announcements.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'There was an error processing your request. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error processing your request. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tabulator-tables@5.5.0/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @section('title', 'Create Announcement')
</x-app-layout>
