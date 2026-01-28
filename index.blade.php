@include('home.header')

<!-- Welcome Banner -->
<section class="text-center py-5 border-bottom" style="background: linear-gradient(135deg, #04beb3 0%, #039d94 100%);">
  <div class="container">
    <h2 class="fw-bold text-white mb-3">Welcome to Book Management System</h2>
    <p class="lead text-white mb-0">Discover your next favorite book</p>
  </div>
</section>

<!-- Search + Tabs -->
<section class="bg-white py-3 shadow-sm border-bottom sticky-top" style="top:0; z-index:1020;">
  <div class="container">
    <div class="position-relative mb-3">
      <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-4 text-muted fs-4"></i>
      <input type="search" class="form-control form-control-lg rounded-pill ps-5 border-primary" placeholder="Search books..." id="globalSearch">
    </div>
    <div class="d-flex overflow-auto gap-2 gap-md-3 hide-scrollbar pb-1">
      <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold active">All</button>
      <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">Best Sellers</button>
      <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">New Releases</button>
      <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">Romance</button>
      <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">Thriller</button>
      <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-bold">Self-Help</button>
    </div>
  </div>
</section>

<div class="container-fluid px-3 px-md-4 px-lg-5 py-5">
  <div class="row g-4">
    <!-- Sidebar -->
    <div class="col-lg-3 d-none d-lg-block">
      <div class="bg-white rounded-3 shadow-sm p-4 border position-sticky" style="top: 100px;">
        <h5 class="fw-bold mb-4 pb-3 border-bottom">
          <i class="fas fa-filter me-2 text-primary"></i> Filters
        </h5>
        <!-- Price -->
        <div class="mb-4">
          <label class="form-label fw-semibold d-block mb-2"><i class="fas fa-rupee-sign me-2"></i> Price</label>
          <input type="range" class="form-range mb-2" id="priceRange" min="0" max="2000" value="2000" step="50">
          <div class="d-flex justify-content-between small text-muted mb-3">
            <span>₹0</span>
            <span id="priceRangeValue">Up to ₹2000+</span>
          </div>
          <div class="d-flex gap-2">
            <input type="number" class="form-control form-control-sm" placeholder="Min" id="priceMin">
            <input type="number" class="form-control form-control-sm" placeholder="Max" id="priceMax">
          </div>
        </div>
        <!-- Category -->
        <div class="mb-4">
          <label class="form-label fw-semibold d-block mb-2"><i class="fas fa-bookmark me-2"></i> Category</label>
          <select class="form-select form-select-sm" id="genreFilter">
            <option value="all">All Categories</option>
            <option value="romance">Romance</option>
            <option value="thriller">Mystery & Thriller</option>
            <option value="selfhelp">Self-Help</option>
            <option value="punjabi">Punjabi</option>
            <option value="biography">Biographies</option>
            <option value="fantasy">Fantasy</option>
          </select>
        </div>
        <!-- Availability -->
        <div class="mb-4">
          <label class="form-label fw-semibold d-block mb-2">
            <i class="fas fa-check-circle me-2"></i> Availability
          </label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="inStock" checked>
            <label class="form-check-label" for="inStock">In Stock</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="outOfStock">
            <label class="form-check-label" for="outOfStock">Out of Stock</label>
          </div>
        </div>
        <!-- Language -->
        <div class="mb-4">
          <label class="form-label fw-semibold d-block mb-2"><i class="fas fa-globe me-2"></i> Language</label>
          <select class="form-select form-select-sm" id="languageFilter" multiple size="4">
            <option value="english" selected>English</option>
            <option value="punjabi">Punjabi</option>
            <option value="hindi">Hindi</option>
            <option value="others">Others</option>
          </select>
        </div>
        <!-- Year -->
        <div class="mb-4">
          <label class="form-label fw-semibold d-block mb-2"><i class="fas fa-calendar-alt me-2"></i> Published After</label>
          <input type="number" class="form-control form-control-sm" id="yearFrom" placeholder="e.g. 2015">
        </div>
        <!-- Rating -->
        <div class="mb-5">
          <label class="form-label fw-semibold d-block mb-2"><i class="fas fa-star me-2"></i> Min Rating</label>
          <select class="form-select form-select-sm" id="minRating">
            <option value="0">Any</option>
            <option value="3">3+</option>
            <option value="4">4+</option>
            <option value="4.5">4.5+</option>
          </select>
        </div>
        <button onclick="clearAllFilters()" class="btn btn-outline-secondary w-100 py-3 fw-bold">Reset Filters</button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-12 col-lg-9">
      <div class="mb-5">
        <h4 class="fw-bold mb-3">Best Sellers</h4>
        <div class="position-relative">
          <div id="bestSellersScroll" class="d-flex overflow-x-auto gap-3 pb-3 hide-scrollbar scroll-smooth">
            @foreach ($books as $book)
            {{-- @php
    dd($books);
@endphp --}}
              <div class="book-item best-item flex-shrink-0 text-center"
                   data-price="{{ $book->price }}"
                   data-category="{{ $book->category }}"
                   data-format="{{ $book->format }}"
                   data-availability="{{ htmlspecialchars($book->availability) }}"
                   data-language="{{ $book->language }}"
                   data-year="{{ $book->pub_year }}"
                   data-rating="{{ $book->rating }}">
                <a href="{{ route('book.detail') }}?book={{ urlencode(json_encode($book)) }}" class="text-decoration-none text-dark">
                  <img src="{{ $book->image }}" class="rounded shadow-sm" style="width:158px;height:228px;object-fit:cover;" alt="{{ htmlspecialchars($book->title) }}">
                  <p class="small fw-bold mt-2 mb-1 text-truncate" style="max-width:158px;">{{ htmlspecialchars($book->title) }}</p>
                  <p class="text-primary fw-bold small mb-0">₹{{ number_format($book->price) }}</p>
                  @if (!empty($book->old_price) && $book->old_price > $book->price)
                    <small class="text-muted text-decoration-line-through">₹{{ number_format($book->old_price) }}</small>
                  @endif
                </a>
              </div>
            @endforeach
          </div>
          <button class="scroll-arrow left d-none" onclick="scrollSection('bestSellersScroll', -300)"><i class="fas fa-chevron-left"></i></button>
          <button class="scroll-arrow right" onclick="scrollSection('bestSellersScroll', 300)"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>

      <div class="mb-5">
        <h4 class="fw-bold mb-3">New Releases</h4>
        <div class="position-relative">
          <div id="newReleasesScroll" class="d-flex overflow-x-auto gap-3 pb-3 hide-scrollbar scroll-smooth">
            @foreach ($books->reverse() as $book)
              <div class="book-item new-item flex-shrink-0 text-center"
                   data-price="{{ $book->price }}"
                   data-category="{{ $book->category }}"
                   data-format="{{ $book->format }}"
                   data-availability="{{ htmlspecialchars($book->availability) }}"
                   data-language="{{ $book->language }}"
                   data-year="{{ $book->pub_year }}"
                   data-rating="{{ $book->rating }}">
                <a href="{{ route('book.detail') }}?book={{ urlencode(json_encode($book)) }}" class="text-decoration-none text-dark">
                  <img src="{{ $book->image }}" class="rounded shadow-sm" style="width:158px;height:228px;object-fit:cover;" alt="{{ htmlspecialchars($book->title) }}">
                  <p class="small fw-bold mt-2 mb-1 text-truncate" style="max-width:158px;">{{ htmlspecialchars($book->title) }}</p>
                  <p class="text-primary fw-bold small mb-0">₹{{ number_format($book->price) }}</p>
                  @if (!empty($book->old_price) && $book->old_price > $book->price)
                    <small class="text-muted text-decoration-line-through">₹{{ number_format($book->old_price) }}</small>
                  @endif
                </a>
              </div>
            @endforeach
          </div>
          <button class="scroll-arrow left d-none" onclick="scrollSection('newReleasesScroll', -300)"><i class="fas fa-chevron-left"></i></button>
          <button class="scroll-arrow right" onclick="scrollSection('newReleasesScroll', 300)"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>

@include('home.footer')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
  .hide-scrollbar::-webkit-scrollbar { display: none; }
  .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .scroll-smooth { scroll-behavior: smooth; }
  .book-item { width: 170px; transition: all 0.15s; }
  .book-item:hover { transform: scale(1.04); }
  .scroll-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 44px; height: 44px; border-radius: 50%; background: white;
    border: 1px solid #ddd; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 10; font-size: 1.2rem; color: #555;
    display: flex; align-items: center; justify-content: center;
  }
  .scroll-arrow.left { left: -20px; }
  .scroll-arrow.right { right: -20px; }
  .scroll-arrow.d-none { opacity: 0; pointer-events: none; }
</style>

<script>
function scrollSection(id, amount) {
  const container = document.getElementById(id);
  if (container) {
    container.scrollBy({ left: amount, behavior: 'smooth' });
  }
}

function updateArrows(id) {
  let c = document.getElementById(id);
  if (!c) return;
  let left  = c.parentElement.querySelector('.scroll-arrow.left');
  let right = c.parentElement.querySelector('.scroll-arrow.right');
  if (!left || !right) return;

  let sl = c.scrollLeft;
  let sw = c.scrollWidth - c.clientWidth;

  left.classList.toggle('d-none', sl < 40);
  right.classList.toggle('d-none', sl > sw - 40);
}

$(function() {
  $('#priceRange').on('input', function() {
    let v = parseInt(this.value);
    $('#priceRangeValue').text(v >= 2000 ? 'Up to ₹2000+' : 'Up to ₹' + v);
    $('#priceMax').val(v);
    applyFilters();
  });

  // Changed: removed #borrowable and #digital from event listeners
  $('#priceMax, #priceMin, #yearFrom').on('input', applyFilters);
  $('#genreFilter, #minRating, #inStock, #outOfStock, #languageFilter').on('change', applyFilters);

  function applyFilters() {
    let minP = parseFloat($('#priceMin').val()) || 0;
    let maxP = parseFloat($('#priceMax').val()) || 9999;
    let cat   = $('#genreFilter').val();
    let minR  = parseFloat($('#minRating').val()) || 0;
    let yr    = parseInt($('#yearFrom').val()) || 0;

    // ── New availability logic ───────────────────────────────
    let wantInStock    = $('#inStock').is(':checked');
    let wantOutOfStock = $('#outOfStock').is(':checked');
    // ──────────────────────────────────────────────────────────

    let langs = $('#languageFilter').val() || [];

    // Helper function to avoid code duplication
    function shouldShow($el) {
      let p = parseFloat($el.data('price'));
      let c = $el.data('category');
      let a = String($el.data('availability') || '').toLowerCase();
      let l = $el.data('language');
      let y = parseInt($el.data('year')) || 0;
      let r = parseFloat($el.data('rating')) || 0;

      let matchesPrice   = (p >= minP && p <= maxP);
      let matchesCat     = (cat === 'all' || c === cat);
      let matchesRating  = (r >= minR);
      let matchesYear    = (yr === 0 || y >= yr);

      // Availability logic: if neither checkbox is checked → show all
      let matchesAvailability = true;

      if (wantInStock || wantOutOfStock) {
        matchesAvailability = false;

        if (wantInStock    && a.includes('in stock'))    matchesAvailability = true;
        if (wantOutOfStock && a.includes('out of stock')) matchesAvailability = true;

        // Optional extra keywords you can add if your data uses them:
        // if (wantInStock    && (a.includes('available') || a.includes('instock'))) matchesAvailability = true;
        // if (wantOutOfStock && (a.includes('sold out')  || a.includes('unavailable'))) matchesAvailability = true;
      }

      let matchesLang = (langs.length === 0 || langs.includes(l));

      return matchesPrice && matchesCat && matchesRating && matchesYear &&
             matchesAvailability && matchesLang;
    }

    $('.best-item, .new-item').each(function() {
      $(this).toggle(shouldShow($(this)));
    });

    setTimeout(() => {
      updateArrows('bestSellersScroll');
      updateArrows('newReleasesScroll');
    }, 50);
  }

  window.clearAllFilters = function() {
    $('#genreFilter').val('all');
    $('#priceRange').val(2000);
    $('#priceRangeValue').text('Up to ₹2000+');
    $('#priceMin').val('');
    $('#priceMax').val('');
    
    $('#inStock').prop('checked', true);
    $('#outOfStock').prop('checked', false);  
    
    $('#languageFilter option').prop('selected', false);
    $('#languageFilter option[value="english"]').prop('selected', true);
    
    $('#yearFrom').val('');
    $('#minRating').val('0');
    
    applyFilters();
  };

  applyFilters();

  ['bestSellersScroll', 'newReleasesScroll'].forEach(id => {
    let el = document.getElementById(id);
    if (el) {
      el.addEventListener('scroll', () => updateArrows(id));
      setTimeout(() => updateArrows(id), 300);
    }
  });
});
</script>