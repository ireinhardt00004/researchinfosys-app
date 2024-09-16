<div>
    @if($unreadCount > 0)
        <span>{{ $unreadCount }}</span>
    @endif
    <style>
        /* Style for the notification badge */
        .notification-badge {
            position: absolute;
            top: 10px; 
            right: 3%; 
            background-color: red; 
            color: white; 
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px; 
            font-weight: bold;
            min-width: 20px; 
            text-align: center; 
            z-index: 30
        }
        /* sm:right-0 absolute top-[10px] bg-red-500 rounded-full drop-shadow-lg py-[4px] px-[8px] text-[12px] min-w-[20px] text-center z-30 */
</style>
</div>
