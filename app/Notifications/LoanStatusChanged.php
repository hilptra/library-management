<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LoanStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Loan $loan, public string $action) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        $book = $this->loan->bookCopy?->book;
        $bookTitle = $book ? $book->title : 'Buku';
        $coverImage = $book?->cover_image;

        $titles = [
            'approved' => 'Peminjaman Disetujui',
            'rejected' => 'Peminjaman Ditolak',
            'returned' => 'Buku Telah Dikembalikan',
        ];

        $dueDateFormatted = $this->loan->due_date ? $this->loan->due_date->format('d/m/Y') : null;

        $messages = [
            'approved' => 'Pengajuan peminjaman untuk buku "'.$bookTitle.'" telah disetujui. Batas waktu pengembalian: '.($dueDateFormatted ?? '-').'.',
            'rejected' => 'Pengajuan peminjaman untuk buku "'.$bookTitle.'" ditolak oleh pengelola perpustakaan.',
            'returned' => 'Buku "'.$bookTitle.'" telah berhasil dikembalikan'.($this->loan->fine_amount > 0 ? ' dengan denda Rp '.number_format($this->loan->fine_amount, 0, ',', '.') : '').'. Yuk, berikan rating & ulasan Anda untuk buku ini!',
        ];

        return [
            'title' => $titles[$this->action] ?? 'Status Peminjaman',
            'message' => $messages[$this->action] ?? 'Status peminjaman buku "'.$bookTitle.'" telah diperbarui.',
            'action' => $this->action,
            'loan_id' => $this->loan->id,
            'book_id' => $book?->id,
            'book_title' => $bookTitle,
            'book_cover' => $coverImage,
            'due_date' => $this->loan->due_date?->format('Y-m-d'),
        ];
    }
}
