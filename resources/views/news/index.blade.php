<x-app-layout>
    <div class="py-12 w-full grow rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div>
            <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">News and Announcement</h2>
            </div>
            <div class="overflow-hidden shadow-sm sm:rounded-lg h-full">
                 <div class="p-6 h-full bg-white drop-shadow-lg space-y-3 mb-2 rounded-lg">
                    <div class="flex ">
                    @auth
                    @if (auth()->user()->hasRole('admin'))
                    <a href="{{route('announcements.create') }}"><button class="rounded bg-[#1b651b] p-3 text-white">
                        <i class="fas fa-pencil"></i>     
                        Create Announcement</button></a>
                        @endif @endauth
                        @auth
                        @if (auth()->user()->hasRole('sub-admin'))
                        <a href="{{route('announcements.create') }}"><button class="rounded bg-[#1b651b] p-3 text-white">
                        <i class="fas fa-pencil"></i>     
                        Create Announcement</button></a>
                        @endif @endauth
                    </div>
                 </div>


                 {{-- main post --}}
                @foreach($announcements as $announcement)
                    <div class="p-6 h-full bg-white drop-shadow-lg space-y-3 rounded-lg mt-2">
                        {{-- news head --}}
                    <div class="w-full p-2 flex items-center drop-shadow-lg border-b-2">
                            <div class="flex gap-2 items-center">
                                <img class="object-cover w-[3rem] h-[3rem] rounded-full" src="{{ asset($announcement->user->userinfos->profile_pic)}}" alt="">
                                {{-- name and role --}}
                                <div>
                                    <h2 class="font-semibold text-lg">{{$announcement->user->fname}}
                                    {{$announcement->user->middlename}}
                                    {{$announcement->user->lname}}
                                    </h2>

                                    <h3 class="text-m mb-2 uppercase">{{$announcement->user->roles}}</h3>
                                    <p class="italic">{{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                            
                            </div>
                            
                            <div class="ms-auto space-x-3 flex">
                                {{-- edit button --}}
                                 @if($announcement->user_id === auth()->id())
                                    <a title="Edit Announcement" href="{{ route('announcements.edit', $announcement->id) }}" class="p-2 rounded-full drop-shadow-lg hover:opacity-50 bg-blue-500">
                                        <svg class="h-[1.2rem] w-[1.2rem] drop-shadow-lg fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8477 1.87868C19.6761 0.707109 17.7766 0.707105 16.605 1.87868L2.44744 16.0363C2.02864 16.4551 1.74317 16.9885 1.62702 17.5692L1.03995 20.5046C0.760062 21.904 1.9939 23.1379 3.39334 22.858L6.32868 22.2709C6.90945 22.1548 7.44285 21.8693 7.86165 21.4505L22.0192 7.29289C23.1908 6.12132 23.1908 4.22183 22.0192 3.05025L20.8477 1.87868ZM18.0192 3.29289C18.4098 2.90237 19.0429 2.90237 19.4335 3.29289L20.605 4.46447C20.9956 4.85499 20.9956 5.48815 20.605 5.87868L17.9334 8.55027L15.3477 5.96448L18.0192 3.29289ZM13.9334 7.3787L3.86165 17.4505C3.72205 17.5901 3.6269 17.7679 3.58818 17.9615L3.00111 20.8968L5.93645 20.3097C6.13004 20.271 6.30784 20.1759 6.44744 20.0363L16.5192 9.96448L13.9334 7.3787Z" fill="white"></path> </g></svg>
                                    </a>
                                @endif

                                {{-- delete button --}}
                                 @if($announcement->user_id === auth()->id())

                                  <form class="t" action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" id="delete-form-{{ $announcement->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="confirmDelete({{ $announcement->id }})" class="p-2 rounded-full drop-shadow-lg hover:opacity-50 bg-red-500" title="Delete Announcement">
                                        <svg class="h-[1.2rem] w-[1.2rem] drop-shadow-lg stroke-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 12V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 12V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                    </div>
                    {{-- news content --}}
                    <div class="drop-shadow-xl flex flex-col gap-3  w-full h-full rounded-lg p-2">
                            {{-- news title --}}
                            <div class="w-full">
                                <h2 class="text-xl font-bold">{{ $announcement->title }}</h2>
                            </div>

                            {{-- content body --}}
                            <div class="flex sm:flex-row flex-col-reverse w-full sm:space-x-3">
                                {{-- content text --}}
                                <div class="sm:w-1/2 w-full h-[310px] overflow-y-auto">
                                    <p class="break-all p-2">
                                        {{ $announcement->content }}
                                    </p>
                                </div>

                                {{-- content img --}}
                                <div class="rounded-lg inline-grid overflow-x-auto grid-flow-col auto-cols-[50%] sm:h-[40%] h-[60%] w-full  sm:w-[50%] gap-4">
                                    <img class="rounded-lg object-contain size-[100%]" src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">
                                    <img class="rounded-lg object-contain size-[100%]" src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">
                                    <img class="rounded-lg object-contain size-[100%]" src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">
                                    <img class="rounded-lg object-contain size-[100%]" src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">
                                    
                                </div>
                            </div>

                    </div>
                    {{-- like, comment, time --}}
                    <div class="p-2 w-full border-t-2 mt-3 flex items-center">
                    @livewire('heart-react', ['announcementId' => $announcement->id])
                            {{-- timestamp section --}}
                            <!-- <div class="ms-auto p-2 bg-white drop-shadow-lg rounded-lg text-sm">
                                <p>{{ $announcement->created_at->diffForHumans() }}</p>
                            </div> -->
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
<script>
   function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the announcement.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }     
</script>



@section('title','News and Announcement')
</x-app-layout>
