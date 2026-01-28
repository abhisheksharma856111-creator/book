<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Home page - latest books display
     */
    public function index()
    {
        $books = Book::with(['author', 'category', 'publisher'])
            ->latest('created_at')
            ->take(20)
            ->get()
            ->map(function ($book) {
                $oldPrice = $book->old_price ?? ($book->price ? (int)($book->price * 1.4) : 799);
                $discountPercent = $book->discount ?? ($oldPrice > $book->price ? round((($oldPrice - $book->price) / $oldPrice) * 100) : 0);

                return (object) [
                    'id'           => $book->id,
                    'title'        => $book->title ?? 'Untitled Book',
                    'author'       => $book->author?->name ?? 'Unknown Author',
                    'price'        => (float) ($book->price ?? 299),
                    'old_price'    => $oldPrice,
                    'discount'     => $discountPercent > 0 ? $discountPercent . '% OFF' : '',
                    'availability' => $book->available ? 'In Stock • Can be borrowed' : 'Out of Stock',
                    'format'       => 'physical,digital',
                    'language'     => $book->language ?? 'english',
                    'pages'        => $book->pages ?? 320,
                    'pub_year'     => $book->publication_date ?? date('Y', strtotime($book->created_at ?? now())),
                    'rating'       => $book->average_rating ?? number_format(rand(38, 47) / 10, 1),
                    'image'        => $book->cover_image
                                      ? asset('storage/app/public/' . $book->cover_image) // Correct path for cover image
                                      : 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=400',
                    'category'     => $book->category?->slug ?? $book->category?->name ?? 'general',
                    'description'  => $book->description ?? 'No description available at the moment.',
                    'publisher'    => $book->publisher?->name ?? 'Not specified',
                    'isbn'         => $book->isbn ?? 'N/A',
                    'pub_date'     => $book->publication_date ?? date('F j, Y', strtotime($book->created_at ?? now())),
                    'author_bio'   => $book->author?->about ?? 'No author information available.',
                    'sample_url'   => $book->sample_file ?? 'https://filesamples.com/samples/document/pdf/sample-pdf.pdf',
                ];
            });

        return view('home.index', compact('books'));
    }

    /**
     * Book detail page
     * Now properly loads author relationship and passes it to view
     */
    public function show(Request $request)
    {
        $encoded = $request->query('book');

        if (!$encoded) {
            return redirect()->route('home')->with('error', 'No book selected');
        }

        $json = urldecode($encoded);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data) || empty($data['title'])) {
            return redirect()->route('home')->with('error', 'Invalid book data');
        }

        // Important: Load book with author relationship
        $book = Book::with('author')->find($data['id'] ?? 0);

        if ($book) {
            $bookDetail = (object) array_merge((array)$data, [
                'average_rating' => $book->average_rating ?? 0,
                'review_count'   => $book->review_count ?? 0,
                'reviews_json'   => $book->reviews_json ?? [],
                'sample_url'     => $book->sample_file
                    ? asset('storage/app/public/books/samples/' . basename($book->sample_file)) 
                    : null,
                'author_name'    => $book->author?->name,
                'author_bio'     => $book->author?->about,
                'author_image' => 'image',

            ]);

            $author = $book->author; 
        } else {
            $bookDetail = (object) $data;
            $author = null;
        }

        $related = Book::with('author')
            ->inRandomOrder()
            ->take(4)
            ->get()
            ->map(function ($b) {
                return (object) [
                    'id'       => $b->id,
                    'title'    => $b->title,
                    'author'   => $b->author?->name ?? 'Unknown',
                    'price'    => (float) ($b->price ?? 299),
                    'image'    => $b->cover_image ? asset('storage/app/public/' . $b->cover_image) : 'https://images.unsplash.com/photo-1544947950-fa07a98d4679?w=400',
                    'discount' => '15% Off',
                ];
            });

        return view('home.book-detail', compact('bookDetail', 'related', 'author'));
    }
}
