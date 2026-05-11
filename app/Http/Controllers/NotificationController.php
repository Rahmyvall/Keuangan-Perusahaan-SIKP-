<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function fetch()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'notifications' => [],
                'total_unread' => 0
            ]);
        }

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $total_unread = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications->map(function ($notif) {
                return [
                    'id'       => $notif->id,
                    'title'    => $notif->title,
                    'message'  => $notif->message,
                    'time'     => $notif->created_at->diffForHumans(),
                    'icon'     => $notif->icon ?? 'feather icon-bell',
                    'color'    => $notif->color ?? 'text-primary',
                    'link'     => $notif->link ?? '#',
                    'is_read'  => $notif->is_read,
                ];
            }),
            'total_unread' => $total_unread
        ]);
    }

    public function markAllRead()
    {
        $user = auth()->user();
        if ($user) {
            Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}