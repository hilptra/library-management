<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = Auth::user()->notifications();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->paginate(12)->withQueryString();
        $unreadCount = Auth::user()->unreadNotifications()->count();
        $totalCount = Auth::user()->notifications()->count();

        return view('member.notification.index', compact('notifications', 'filter', 'unreadCount', 'totalCount'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi berhasil ditandai sebagai sudah dibaca.');
    }

    public function markAsRead(string $id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca.');
    }

    public function open(string $id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            $data = $notification->data;
            if (!empty($data['book_id'])) {
                return redirect()->route('member.books.show', $data['book_id']);
            }
        }

        return redirect()->route('member.loans.index');
    }

    public function destroy(string $id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();

        return back()->with('success', 'Semua notifikasi berhasil dibersihkan.');
    }
}
