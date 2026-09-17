<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberLoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_request_book_loan(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
            'status' => 'active',
        ]);

        $book = Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'isbn' => '978-979-3062-79-2',
            'published_year' => 2005,
        ]);

        $copy = BookCopy::create([
            'book_id' => $book->id,
            'inventory_code' => 'BOOK-1-01',
            'status' => 'available',
        ]);

        $response = $this->actingAs($user)->post("/member/books/{$book->id}/loans");

        $response->assertRedirect(route('member.books.show', $book));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('loans', [
            'user_id' => $user->id,
            'book_copy_id' => $copy->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('book_copies', [
            'id' => $copy->id,
            'status' => 'reserved',
        ]);
    }

    public function test_member_can_cancel_pending_loan(): void
    {
        $user = User::factory()->create([
            'role' => 'member',
            'status' => 'active',
        ]);

        $book = Book::create([
            'title' => 'Bumi Manusia',
            'author' => 'Pramoedya Ananta Toer',
            'isbn' => '978-979-97312-3-4',
            'published_year' => 1980,
        ]);

        $copy = BookCopy::create([
            'book_id' => $book->id,
            'inventory_code' => 'BOOK-2-01',
            'status' => 'reserved',
        ]);

        $loan = Loan::create([
            'user_id' => $user->id,
            'book_copy_id' => $copy->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->patch(route('member.loans.cancel', $loan));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'status' => 'cancelled',
        ]);

        $this->assertDatabaseHas('book_copies', [
            'id' => $copy->id,
            'status' => 'available',
        ]);
    }
}
