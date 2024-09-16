<x-app-layout>
    <div class="py-12 w-full grow bg-white rounded-lg drop-shadow-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-scren">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900 h-full">
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
                <style>
    .tulongPost {
        padding: 2.75rem;
        width: 100%;
        height: 70%;
        gap: 1rem;
        border-radius: .5rem;
        background-color: white;
        padding: 1rem .75rem;
        display: flex;
        justify-content: center;
        align-items: center;
         margin-bottom: .75rem;
    }

    .tulongtext {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-justify: auto;
        overflow-y: auto;
    }
    .tulongpara{
        height: 100%;
        width: 100%;
        overflow-y: auto;
    }
    .tulongpara>h1 {
        font-size: 1.25rem;
    }

    .tulongpara>p {
        font-size: 1rem;
    }

    .tulongimgs {
        width: 100%;
        height: 70%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-justify: auto;
        overflow-x: auto;
        gap: .5rem;
        background: #dddcdc;
        justify-self: start;
        align-self: self-start;
        border-radius: .5rem;
    }
    .tulongimgs > img{
        object-fit: cover;
        object-position: center;
        border-radius: .5rem;
        width: 100%;
        height: 100%;
        flex-shrink: 0;
        padding: .5rem;
    }

    .tulongButton {
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .tulongButton button {
        padding: .75rem;
        border: none;
        background-color: transparent;
        border-radius: .5rem;
    }
    .tulongButton button:hover{
         background-color: #dddcdc;
     }
    .t{
        padding: .75rem;
        border: none;
        background-color: transparent;
        border-radius: .5rem;
    }
    .bodymainHide{
        display: grid;
        grid-template-columns: 0% 100%;
        height: 100dvh;
        /* Adjust height based on your layout needs */
        
        background-color: #f0eceb;
    }

    /* mediaquery */

@media screen and (max-width: 640px) {
      .tulongPost {
        padding: 2.75rem;
        width: 100%;
        height: 70%;
        gap: 1rem;
        border-radius: .5rem;
        background-color: white;
        padding: 1rem .75rem;
        display: flex;
        flex-direction: column-reverse;
        justify-content: center;
        align-items: center;
         margin-bottom: .75rem;
    }
     .tulongtext {
        width: 100%;
        height: 90%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-justify: auto;
        overflow-y: auto;
    }

    .tulongpara>h1 {
        font-size: .75rem;
    }

    .tulongpara>p {
        font-size: .65rem;
    }
    .tulongpara{
        height: 100%;
        width: 100%;
        overflow-y: auto;
        padding: .7rem;
    }

    .tulongimgs {

        display: flex;
        justify-content: space-between;
        gap: .50rem;
        padding: .75rem;
        border-radius: .5rem;
        width: 100%;
        height:50%;
        overflow-x: auto;
    }
    .tulongimgs > img{
        object-fit: contain;
        object-position: center;
        border-radius: .5rem;
        width: 100%;
        height: 100%;
         flex-shrink: 0;
    }
}

</style> 
    
        @foreach($announcements as $announcement)
        <div class="tulongPost">
            <div class="tulongtext">
                    <div class="tulongpara example">
                        <h1 class="font-bold uppercase">{{ $announcement->title }}</h1>
                        <em>{{ $announcement->created_at->diffForHumans() }}</em>
                        <p>{{ $announcement->content }}</p>  
                    </div>
<div class="tulongButton">
    <!-- First SVG Button (Existing) -->
    <button>
        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"
                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>

    <!-- Second SVG Button (Existing) -->
    <button>
        <svg width="24px" height="24px" viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M9.1631 5H15.8381C17.8757 5.01541 19.5151 6.67943 19.5001 8.717V13.23C19.5073 14.2087 19.1254 15.1501 18.4384 15.8472C17.7515 16.5442 16.8158 16.9399 15.8371 16.947H9.1631L5.5001 19V8.717C5.49291 7.73834 5.8748 6.79692 6.56175 6.09984C7.24871 5.40276 8.18444 5.00713 9.1631 5Z"
                stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M7.50009 11C7.50009 10.4477 7.94781 10 8.50009 10C9.05238 10 9.50009 10.4477 9.50009 11C9.50009 11.5523 9.05238 12 8.50009 12C8.23488 12 7.98052 11.8946 7.79298 11.7071C7.60545 11.5196 7.50009 11.2652 7.50009 11Z"
                stroke="#000000" stroke-linecap="round" stroke-linejoin="round" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11.5001 11C11.5001 10.4477 11.9478 10 12.5001 10C13.0524 10 13.5001 10.4477 13.5001 11C13.5001 11.5523 13.0524 12 12.5001 12C11.9478 12 11.5001 11.5523 11.5001 11Z"
                stroke="#000000" stroke-linecap="round" stroke-linejoin="round" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M15.5001 11C15.5001 10.4477 15.9478 10 16.5001 10C17.0524 10 17.5001 10.4477 17.5001 11C17.5001 11.5523 17.0524 12 16.5001 12C15.9478 12 15.5001 11.5523 15.5001 11Z"
                stroke="#000000" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>

    <!-- Edit Button -->
    @if($announcement->user_id === auth()->id())
        <a class="t" href="{{ route('announcements.edit', $announcement->id) }}">
            <button>
                <svg class="w-[1.5rem] h-[1.5rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M8.56078 20.2501L20.5608 8.25011L15.7501 3.43945L3.75012 15.4395V20.2501H8.56078ZM15.7501 5.56077L18.4395 8.25011L16.5001 10.1895L13.8108 7.50013L15.7501 5.56077ZM12.7501 8.56079L15.4395 11.2501L7.93946 18.7501H5.25012L5.25012 16.0608L12.7501 8.56079Z" fill="#080341"></path> </g></svg>
            </button>
        </a>
    @endif

    <!-- Delete Button -->
    @if($announcement->user_id === auth()->id())
        <form class="t" action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" id="delete-form-{{ $announcement->id }}">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete({{ $announcement->id }})">
                <svg class="w-[1.5rem] h-[1.5rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
        </form>
    @endif
</div>

                    </div>
                  
                    <div class="tulongimgs h-1/2 drop-shadow-lg bg-white shadow-lg " >
                    <img src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">
                    <img src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">
                    <img src="{{ asset('announcement_img/' . $announcement->cover) }}" alt="Announcement Image">

                    </div>
                </div>
                </div>
            </div> 
            @endforeach
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
