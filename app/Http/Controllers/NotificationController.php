<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        // Find the notification by ID
        $notification = Notification::findOrFail($id);

        // Update the 'read_at' column to the current timestamp
        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read successfully.']);
    }

    /**
     * Fetch all notifications for the authenticated user.
     */
    public function getNotifications(Request $request)
    {
        // Define the number of notifications to load at a time (default 8)
        $limit = $request->input('limit', 8);
        $offset = $request->input('offset', 0);

        // Retrieve notifications for the authenticated user with offset and limit
        $notifications = Notification::where('n_userID', auth()->id())
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        // Return the notifications as JSON
        return response()->json($notifications);
    }

    /**
     * Clear all notifications for the authenticated user.
     */
    public function clearNotifications()
    {
        // Delete all notifications for the current user
        Notification::where('n_userID', auth()->id())->delete();

        return response()->json(['message' => 'All notifications cleared successfully.']);
    }
}
