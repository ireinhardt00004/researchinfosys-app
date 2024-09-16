 {{-- notification drawer --}}
 <div id="drawerNotif" class="hidden fixed w-full h-full z-30">
    <section class="fixed sm:right-[12%] right-[25%] z-40 bg-white top-[6.5%] rounded-lg p-2 sm:w-[15%] h-[30%] overflow-y-auto">
        <button style="float: right; border: none; color: red; background-color: transparent;" wire:confirm="Do you want to delete all your notifications?" wire:click="deleteAllNotifications" title="Clear all">
            <i class="fa fa-trash"></i>
        </button>
            <h3 class="text-lg font-semibold">Notification</h3>
            <div class="p-2 ms-2">
                 @if($messages->isEmpty())
                 <p>No notifications yet.</p>
             @else
                 <ul>
                     @foreach($messages as $notification)
                         <li wire:click="markAsRead({{ $notification->id }})" style="cursor: pointer; padding: 10px; border-bottom: 1px solid #ddd; display: flex; flex-direction: column; gap: .5rem; {{ !$notification->is_read ? 'font-weight: bold;' : '' }}">
                             <div style="display: flex; flex-direction: column; gap: .5rem; align-items: start; justify-content: flex-start">
                                 <div style="display: flex; gap: .5rem; align-items: center;">
                                      <div style="width: 10px; background-color: red; height: 10px; border-radius: 50%; display: {{ $notification->is_read ? 'none' : 'block' }}
                                     "></div>
                                     <strong>{{ ucwords($notification->sender->roles) }} {{ ucwords($notification->sender->lname) }}</strong>
                                 </div>
                                
                                 <p>{{ $notification->message }}</p>
                             </div>
                             <strong>{{ $notification->created_at->diffForHumans() }}</strong>
                         </li>
                     @endforeach
                 </ul>
             @endif
             @push('script')
             <script>
                 Livewire.on('notificationUpdated', () => {
                     window.location.reload();
                 });
             </script>
             @endpush
            </div>
        </section>
    <div id="notif" class="fixed bg-black opacity-40 w-full h-full z-30"></div>

</div>