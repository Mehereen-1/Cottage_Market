<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // 📨 Show all notifications in a dropdown view
    public function index()
    {
        $user = Auth::user();

        // Fetch all notifications (latest first)
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return view('notifications.index', compact('notifications'));
    }

    // 🧭 AJAX: Fetch unread notifications (for navbar dropdown)
    public function fetch()
    {
        $user = Auth::user();
        $unread = $user->unreadNotifications()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'count' => $unread->count(),
            'notifications' => $unread
        ]);
    }

    // 🧹 Mark all notifications as read
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read']);
    }

    // ✅ Mark single notification as read
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read']);
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }
}
