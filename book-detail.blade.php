@include('home.header')



<style>

  :root {

    --primary: #04beb3;

    --primary-dark: #039d94;

  }

  .btn-primary { background: var(--primary); border-color: var(--primary); }

  .btn-primary:hover { background: var(--primary-dark); }

  .text-primary { color: var(--primary) !important; }

  .hero-img { box-shadow: 0 20px 40px rgba(0,0,0,0.15); transition: transform .3s; }

  .hero-img:hover { transform: scale(1.03); }

  .nav-tabs .nav-link { border: none; border-bottom: 3px solid transparent; color: #6b7280; }

  .nav-tabs .nav-link.active { color: var(--primary); border-bottom-color: var(--primary); font-weight: 600; }

  .review-card { border-left: 4px solid var(--primary); }

  .star-gold { color: #f59e0b; }

  .hover-shadow:hover {

    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;

    transform: translateY(-5px);

    transition: all 0.3s ease;

  }



  .star-rating label {

    cursor: pointer;

    font-size: 1.8rem;

    color: #ddd;

    transition: color 0.2s;

  }

  .star-rating input[type="radio"]:checked ~ label,

  .star-rating label:hover,

  .star-rating label:hover ~ label {

    color: #f59e0b;

  }

  .star-rating input[type="radio"] {

    display: none;

  }



  .description-content {

    max-height: 6rem;         

    overflow: hidden;

    transition: max-height 0.45s ease;

    position: relative;

  }



  .description-content.expanded {

    max-height: none;

  }



  .read-more-toggle {

    transition: all 0.3s ease;

  }



  .read-more-toggle i {

    transition: transform 0.3s ease;

  }



  .read-more-toggle.expanded i {

    transform: rotate(180deg);

  }

</style>



<div class="container my-5 pt-4">

  <div class="row g-5">

    <!-- Book Image + Action Buttons -->

    <div class="col-lg-5">

      <div class="bg-white rounded-4 shadow-lg p-4 text-center position-relative">

        <img src="{{ $bookDetail->image ?? 'https://via.placeholder.com/400x600?text=No+Image' }}"

             class="img-fluid hero-img rounded-3" 

             alt="{{ $bookDetail->title ?? 'Book' }}"

             style="max-height:540px; object-fit:contain;">

      </div>



      <div class="d-flex gap-3 mt-4">

        <button 

          type="button" 

          class="btn btn-primary flex-grow-1 py-3 fs-5 add-to-cart-btn"

          data-book-id="{{ $bookDetail->id ?? '' }}"

        >

          <i class="fas fa-cart-plus me-2"></i> Add to Cart

        </button>



        <button 

          type="button" 

          class="btn btn-outline-primary flex-grow-1 py-3 fs-5 buy-now-btn"

          data-book-id="{{ $bookDetail->id ?? '' }}"

        >

          <i class="fas fa-rupee-sign me-2"></i> Buy Now – ₹{{ number_format($bookDetail->price ?? 0) }}

        </button>

      </div>



      <!-- Error message container (initially hidden) -->

      <div id="auth-message" class="alert alert-warning mt-3 d-none text-center" role="alert">

        Please login to continue

      </div>



      <div class="text-center mt-4">

        <span class="badge bg-success me-2 px-3 py-2">Free Shipping</span>

        <span class="badge bg-info me-2 px-3 py-2">7-Day Return</span>

      </div>

    </div>



    <!-- Book Information -->

    <div class="col-lg-7">

      <h1 class="fw-bold mb-2">{{ $bookDetail->title ?? 'Unknown Title' }}</h1>

      <p class="fs-4 text-muted mb-4">

        by <strong>{{ $bookDetail->author ?? 'Unknown Author' }}</strong>

      </p>



      <div class="mb-4 d-flex align-items-center flex-wrap gap-3">

        <span class="fs-2 fw-bold text-primary">

          ₹{{ number_format($bookDetail->price ?? 0) }}

        </span>



        @if(isset($bookDetail->old_price) && $bookDetail->old_price > ($bookDetail->price ?? 0))

          <span class="fs-5 text-decoration-line-through text-muted">

            ₹{{ number_format($bookDetail->old_price) }}

          </span>

          @if(!empty($bookDetail->discount))

            <span class="badge bg-dark fs-5 px-3 py-2">{{ $bookDetail->discount }}</span>

          @endif

        @endif



        <span class="fs-5">

          ★ {{ number_format($bookDetail->average_rating ?? 0, 1) }}

        </span>

      </div>



      <div class="d-flex gap-5 mb-5 flex-wrap">

        <div>

          <h6 class="fw-semibold mb-1 text-muted">Availability</h6>

          <span class="badge bg-success fs-6 px-3 py-2">

            {{ $bookDetail->availability ?? 'In Stock' }}

          </span>

        </div>

        <div>

          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sampleModal">

            <i class="fas fa-book-open me-2"></i> Read Sample

          </button>

        </div>

      </div>



      <!-- Tabs Navigation -->

      <ul class="nav nav-tabs mb-4" id="bookTabs">

        <li class="nav-item"><button class="nav-link active" data-tab="description">Description</button></li>

        <li class="nav-item"><button class="nav-link" data-tab="details">Details</button></li>

        <li class="nav-item"><button class="nav-link" data-tab="author">Author</button></li>

        <li class="nav-item"><button class="nav-link" data-tab="reviews">Reviews</button></li>

      </ul>



      <!-- Description Tab -->

      <div id="tab-description" class="tab-content">

        <h5 class="fw-bold mb-3">Description</h5>

        <div class="border rounded-3 p-4 bg-white shadow-sm">

          <div class="description-content text-secondary lh-lg" id="descriptionContent">

            {!! nl2br(e($bookDetail->description ?? 'No description available.')) !!}

          </div>



          <button class="btn btn-link text-primary p-0 mt-2 fw-semibold read-more-toggle d-none" id="readMoreBtn">

            Read more <i class="fas fa-chevron-down ms-1 small"></i>

          </button>

        </div>

      </div>



      <!-- Details Tab -->

      <div id="tab-details" class="tab-content" style="display:none;">

        <h5 class="fw-bold mb-3">Product Details</h5>

        <div class="bg-white border rounded-3 p-4 shadow-sm">

          <table class="table table-borderless mb-0">

            <tr><th width="140">Publisher</th><td>{{ e($bookDetail->publisher ?? '-') }}</td></tr>

            <tr><th>Language</th><td>{{ e($bookDetail->language ?? '-') }}</td></tr>

            <tr><th>Pages</th><td>{{ e($bookDetail->pages ?? '-') }} pages</td></tr>

            <tr><th>ISBN</th><td>{{ e($bookDetail->isbn ?? '-') }}</td></tr>

            <tr><th>Publication Date</th><td>{{ e($bookDetail->pub_date ?? '-') }}</td></tr>

          </table>

        </div>

      </div>



      <!-- Author Tab -->

      <div id="tab-author" class="tab-content" style="display:none;">

        <h5 class="fw-bold mb-4">About the Author</h5>



        @if($author)

          <div class="d-flex flex-column flex-md-row gap-4">

            <div class="text-center">

              @if($author->image)

                <img src="{{ asset('storage//app/public/' . $author->image) }}" 
     alt="{{ $author->name }}" 
     class="rounded-circle shadow" 
     style="width: 140px; height: 140px; object-fit: cover;">


              @else

                <img src="https://via.placeholder.com/140?text=Author" 

                     class="rounded-circle shadow" 

                     alt="Author placeholder">

              @endif

            </div>



            <div class="flex-grow-1">

              <h4 class="fw-bold mb-2">{{ $author->name }}</h4>

              

              <div class="border rounded-3 p-4 bg-white shadow-sm">

                <div class="description-content text-secondary lh-lg" id="authorBioContent">

                  {!! nl2br(e($author->about ?? 'No detailed biography available yet.')) !!}

                </div>



                <button class="btn btn-link text-primary p-0 mt-2 fw-semibold read-more-toggle expanded" id="authorReadMoreBtn">

                  Read more <i class="fas fa-chevron-down ms-1 small"></i>

                </button>

              </div>

            </div>

          </div>

        @else

          <p class="text-muted">Author information not found: {{ $bookDetail->author ?? 'Unknown' }}</p>



          @if(!empty($bookDetail->author_bio))

            <div class="border rounded-3 p-4 bg-white shadow-sm mt-3">

              <div class="description-content text-secondary lh-lg" id="fallbackAuthorBio">

                {!! nl2br(e($bookDetail->author_bio)) !!}

              </div>



              <button class="btn btn-link text-primary p-0 mt-2 fw-semibold read-more-toggle d-none" id="fallbackReadMoreBtn">

                Read more <i class="fas fa-chevron-down ms-1 small"></i>

              </button>

            </div>

          @endif

        @endif

      </div>



      <!-- Reviews Tab -->

      <div id="tab-reviews" class="tab-content" style="display:none;">

        <h5 class="fw-bold mb-4">

          Customer Reviews

          <span class="text-primary ms-2">

            ★ {{ number_format($bookDetail->average_rating ?? 0, 1) }}

            ({{ $bookDetail->review_count ?? 0 }} {{ ($bookDetail->review_count ?? 0) === 1 ? 'review' : 'reviews' }})

          </span>

        </h5>



        @if (auth()->check())

          <div class="card shadow-sm mb-4">

            <div class="card-body">

              <h6 class="fw-bold mb-3">Write a Review</h6>



              @if (session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                  {{ session('success') }}

                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                </div>

              @endif

              @if (session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                  {{ session('error') }}

                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                </div>

              @endif



              <form action="{{ route('reviews.store') }}" method="POST">

                @csrf

                <input type="hidden" name="book_id" value="{{ $bookDetail->id ?? '' }}">



                <div class="mb-3">

                  <label class="form-label fw-bold">Your Rating</label>

                  <div class="star-rating d-flex flex-row-reverse justify-content-end">

                    @for ($i = 5; $i >= 1; $i--)

                      <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="d-none" required>

                      <label for="star{{ $i }}" class="star-label fs-3 mx-1">★</label>

                    @endfor

                  </div>

                </div>



                <div class="mb-3">

                  <label class="form-label fw-bold">Your Review</label>

                  <textarea name="comment" class="form-control" rows="4" placeholder="What did you think of this book?"></textarea>

                </div>



                <button type="submit" class="btn btn-primary">Submit Review</button>

              </form>

            </div>

          </div>

        @else

          <div class="alert alert-info text-center mb-4">

            <strong>Please log in to write a review.</strong>

          </div>

        @endif



        @php

          $reviews = is_array($bookDetail->reviews_json ?? null) ? $bookDetail->reviews_json : [];

        @endphp



        @if (count($reviews) > 0)

          @foreach ($reviews as $review)

            <div class="card review-card mb-3 shadow-sm">

              <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-2">

                  <strong>Anonymous User</strong>

                  <span class="text-warning">

                    @for ($s = 1; $s <= 5; $s++)

                      <i class="{{ $s <= ($review['rating'] ?? 0) ? 'fas fa-star' : 'far fa-star' }}"></i>

                    @endfor

                  </span>

                </div>

                <small class="text-muted d-block mb-2">

                  {{ $review['created_at'] ?? 'Recently' }}

                </small>

                <p class="mb-0">{{ $review['comment'] ?? 'No comment provided.' }}</p>

              </div>

            </div>

          @endforeach

        @else

          <p class="text-muted text-center py-4">No reviews yet. Be the first to share your thoughts!</p>

        @endif

      </div>

    </div>

  </div>



  <!-- Related Books Section -->

  <div class="mt-5 pt-5 border-top">

    <h3 class="fw-bold mb-4 text-center">Products related to this item</h3>

    <div class="row g-4">

      @forelse ($related ?? [] as $rel)

        <div class="col-md-6 col-lg-3">

          <div class="card h-100 border-0 shadow-sm hover-shadow">

            <img src="{{ $rel->image ?? 'https://via.placeholder.com/300x400?text=No+Image' }}"

                 class="card-img-top" alt="{{ $rel->title ?? 'Book' }}"

                 style="height:280px; object-fit:cover;">

            <div class="card-body text-center">

              <h6 class="card-title fw-bold mb-1">{{ $rel->title ?? 'Unknown' }}</h6>

              <p class="text-muted small mb-2">by {{ $rel->author ?? '-' }}</p>

              <div class="mb-2">

                <span class="fw-bold text-primary">₹{{ number_format($rel->price ?? 0) }}</span>

                @if(!empty($rel->discount))

                  <span class="badge bg-dark ms-2">{{ $rel->discount }}</span>

                @endif

              </div>

              <a href="{{ route('book.detail', $rel->id ?? '') }}" 

                 class="btn btn-sm btn-outline-primary">View Details</a>

            </div>

          </div>

        </div>

      @empty

        <p class="text-center text-muted">No related books found.</p>

      @endforelse

    </div>

  </div>

</div>



<!-- Sample Preview Modal -->

<div class="modal fade" id="sampleModal" tabindex="-1" aria-labelledby="sampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="sampleModalLabel">

          Sample — {{ $bookDetail->title ?? 'Book Sample' }}

        </h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body p-4">

        @if(!empty($bookDetail->sample_url))

          <iframe src="{{ $bookDetail->sample_url }}" width="100%" height="600px" style="border: none;"></iframe>

          <div class="mt-4 text-center">

            <p class="text-muted">You are viewing a sample of the book. To download the full PDF, click below.</p>

          </div>

        @else

          <p class="text-center text-muted py-5">

            No sample preview available for this book.

          </p>

        @endif

      </div>

      <div class="modal-footer d-flex justify-content-between">

        <div class="alert alert-warning mb-0">

          <strong>Important:</strong> To download the full PDF, you need to purchase the book.

        </div>

        <button type="button" class="btn btn-success btn-lg" style="width: 150px;">Buy Now</button>

      </div>

    </div>

  </div>

</div>



<script>

// Reusable function to initialize Read More / Read Less

function initReadMore(containerId, buttonId) {

  const content = document.getElementById(containerId);

  const button = document.getElementById(buttonId);



  if (!content || !button) return;



  // Check if content overflows (with small tolerance)

  const isOverflowing = content.scrollHeight > content.clientHeight + 12;



  if (isOverflowing) {

    button.classList.remove('d-none');

  }



  button.addEventListener('click', function () {

    content.classList.toggle('expanded');



    if (content.classList.contains('expanded')) {

      button.innerHTML = 'Read less <i class="fas fa-chevron-up ms-1 small"></i>';

      button.classList.add('expanded');

    } else {

      button.innerHTML = 'Read more <i class="fas fa-chevron-down ms-1 small"></i>';

      button.classList.remove('expanded');

    }

  });

}



document.addEventListener('DOMContentLoaded', function () {

  const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

  const userRole   = "{{ auth()->check() ? auth()->user()->role : '' }}";

  const authMessage = document.getElementById('auth-message');



  // Tab switching

  document.querySelectorAll('#bookTabs button').forEach(btn => {

    btn.addEventListener('click', () => {

      document.querySelectorAll('#bookTabs .nav-link').forEach(b => b.classList.remove('active'));

      btn.classList.add('active');

      

      document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');

      document.getElementById('tab-' + btn.dataset.tab).style.display = 'block';

    });

  });



  // Initialize Read More for Description

  initReadMore('descriptionContent', 'readMoreBtn');



  // Initialize Read More for Author bio (main author record)

  initReadMore('authorBioContent', 'authorReadMoreBtn');



  // Initialize Read More for fallback author bio

  initReadMore('fallbackAuthorBio', 'fallbackReadMoreBtn');



  // Add to Cart button

  document.querySelectorAll('.add-to-cart-btn').forEach(btn => {

    btn.addEventListener('click', function () {

      if (!isLoggedIn) {

        authMessage.textContent = "Please login to add items to cart";

        authMessage.classList.remove('d-none');

        setTimeout(() => authMessage.classList.add('d-none'), 4000);

        return;

      }



      if (userRole !== 'user') {

        authMessage.textContent = "Only regular users can add to cart";

        authMessage.classList.remove('d-none');

        setTimeout(() => authMessage.classList.add('d-none'), 4000);

        return;

      }



      alert("Added to cart! (implement AJAX here)");

    });

  });



  // Buy Now button

  document.querySelectorAll('.buy-now-btn').forEach(btn => {

    btn.addEventListener('click', function () {

      if (!isLoggedIn) {

        authMessage.textContent = "Please login to proceed with purchase";

        authMessage.classList.remove('d-none');

        setTimeout(() => authMessage.classList.add('d-none'), 4000);

        return;

      }



      if (userRole !== 'user') {

        authMessage.textContent = "Only regular users can buy books";

        authMessage.classList.remove('d-none');

        setTimeout(() => authMessage.classList.add('d-none'), 4000);

        return;

      }



      alert("Proceeding to checkout... (implement later)");

    });

  });

});

</script>



@include('home.footer')