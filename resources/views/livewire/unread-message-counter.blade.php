<div>
    @if($unreadCount > 0)
        <span>{{ $unreadCount }}</span>
    @endif

    <style>
        /* Style for the unread mf  badge */
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
            z-index: 30;
        }
    </style>
</div>
