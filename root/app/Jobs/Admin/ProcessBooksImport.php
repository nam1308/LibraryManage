<?php

namespace App\Jobs\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProcessBooksImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $collection;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->collection as $rowData) {
            $book = Book::where(['book_cd' => $rowData['book_cd'], 'name' => $rowData['name']])->first();

            if ($book) {
                if ($book->author !== $rowData['author'] || $book->description !== $rowData['description']) {
                    continue;
                }

                $book->increment('quantity', $rowData['quantity']);
                $book->users()->attach([$rowData['user_id'] => ['quantity' => $rowData['quantity']]]);
            } else {
                $newBook = Book::updateOrCreate(
                    ['book_cd' => $rowData['book_cd']],
                    [
                        'name' => $rowData['name'],
                        'quantity' => $rowData['quantity'],
                        'author' => $rowData['author'],
                        'slug' => Str::slug($rowData['name']),
                        'description' => $rowData['description'],
                        'created_at' => Carbon::now(),
                    ]
                );

                $newBook->users()->attach([$rowData['user_id'] => ['quantity' => $rowData['quantity']]]);
                $categories = [$rowData['cate_1'], $rowData['cate_2'], $rowData['cate_3']];
                $newBook->categories()->sync($categories);
            }
        }
    }
}
