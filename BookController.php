<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $books = Book::with(['category', 'author', 'publisher'])
                ->select('books.*')
                ->latest()
                ->get();

            // Important: Make sure PDFs and image URLs are full paths for frontend
            foreach ($books as $book) {
                $book->cover_image_url    = $book->cover_image ? asset('storage/app/public/' . $book->cover_image) : null;
                $book->sample_file_url    = $book->sample_file ? asset('storage/app/public/' . $book->sample_file) : null;
                $book->complete_file_url  = $book->complete_file ? asset('storage/app/public/' . $book->complete_file) : null;
                $book->sample_file_name   = $book->sample_file ? basename($book->sample_file) : null;
                $book->complete_file_name = $book->complete_file ? basename($book->complete_file) : null;
            }

            return response()->json(['books' => $books]);
        }

        $categories = Category::all();
        $authors    = Author::all();
        $publishers = Publisher::all();

        return view('admin.books.index', compact('categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'author_id'        => 'nullable|exists:authors,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'quantity'         => 'required|integer|min:1',
            'price'            => 'nullable|numeric|min:0',
            'discount'         => 'nullable|integer|min:0|max:100',
            'description'      => 'nullable|string',
            'publication_date' => 'nullable|date',
            'isbn'             => 'nullable|string|max:20|unique:books,isbn',
            'language'         => 'nullable|string|max:50',
            'pages'            => 'nullable|integer|min:1',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sample_file'      => 'required|file|mimes:pdf|max:10240',    
            'complete_file'    => 'required|file|mimes:pdf|max:51200',    
        ]);

        $data = $validated;

        

        // Cover Image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['cover_image'] = $request->file('image')->store('books/covers', 'public');
        }

        // Sample PDF - required
        if ($request->hasFile('sample_file') && $request->file('sample_file')->isValid()) {
            $data['sample_file'] = $request->file('sample_file')->store('books/samples', 'public');
        }

        // Complete PDF - required
        if ($request->hasFile('complete_file') && $request->file('complete_file')->isValid()) {
            $data['complete_file'] = $request->file('complete_file')->store('books/complete', 'public');
        }

        $data['available'] = $data['quantity'] ?? 1;

        $book = Book::create($data);

        $book->load(['category', 'author', 'publisher']);

        // Add URLs for frontend
        $book->cover_image_url    = $book->cover_image ? asset('storage/app/public/' . $book->cover_image) : null;
        $book->sample_file_url    = $book->sample_file ? asset('storage/app/public/' . $book->sample_file) : null;
        $book->complete_file_url  = $book->complete_file ? asset('storage/app/public/' . $book->complete_file) : null;
        $book->sample_file_name   = $book->sample_file ? basename($book->sample_file) : null;
        $book->complete_file_name = $book->complete_file ? basename($book->complete_file) : null;

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'book'    => $book
        ], 201);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'author_id'        => 'nullable|exists:authors,id',
            'publisher_id'     => 'nullable|exists:publishers,id',
            'quantity'         => 'required|integer|min:1',
            'price'            => 'nullable|numeric|min:0',
            'discount'         => 'nullable|integer|min:0|max:100',
            'description'      => 'nullable|string',
            'publication_date' => 'nullable|date',
            'isbn'             => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'language'         => 'nullable|string|max:50',
            'pages'            => 'nullable|integer|min:1',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sample_file'      => 'nullable|file|mimes:pdf|max:10240',
            'complete_file'    => 'nullable|file|mimes:pdf|max:51200',
        ]);

        $data = $validated;


        // Cover Image 
        if ($request->hasFile('image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('image')->store('books/covers', 'public');
        }

        // Sample PDF 
        if ($request->hasFile('sample_file')) {
            if ($book->sample_file) {
                Storage::disk('public')->delete($book->sample_file);
            }
            $data['sample_file'] = $request->file('sample_file')->store('books/samples', 'public');
        }

        // Complete PDF 
        if ($request->hasFile('complete_file')) {
            if ($book->complete_file) {
                Storage::disk('public')->delete($book->complete_file);
            }
            $data['complete_file'] = $request->file('complete_file')->store('books/complete', 'public');
        }

        // Update available quantity logic
        if (isset($data['quantity']) && $data['quantity'] != $book->quantity) {
            $difference = $data['quantity'] - $book->quantity;
            $data['available'] = max(0, $book->available + $difference);
        }

        $book->update($data);

        $book->load(['category', 'author', 'publisher']);

        // Add URLs for frontend response
        $book->cover_image_url    = $book->cover_image ? asset('storage/' . $book->cover_image) : null;
        $book->sample_file_url    = $book->sample_file ? asset('storage/' . $book->sample_file) : null;
        $book->complete_file_url  = $book->complete_file ? asset('storage/' . $book->complete_file) : null;
        $book->sample_file_name   = $book->sample_file ? basename($book->sample_file) : null;
        $book->complete_file_name = $book->complete_file ? basename($book->complete_file) : null;

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully',
                'book'    => $book
            ]);
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        // Delete files from storage
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->sample_file) {
            Storage::disk('public')->delete($book->sample_file);
        }
        if ($book->complete_file) {
            Storage::disk('public')->delete($book->complete_file);
        }

        $book->delete();

        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully'
            ]);
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully');
    }
}