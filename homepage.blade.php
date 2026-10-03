@extends('layouts.home')

@section('content')

<!-- ══════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════ -->
<section class="hero">

   
    
    <div class="hero-left">

    <h2 class="hero-title">
        For people that live
    </h2>

    <p class="hero-sub">
        Hydra Lux ® is a fashion & lifestyle brand for everyday humans who want to elevate their lives through transcending adventures and experiences.
    </p>

    <div class="hero-ctas">
        <a href="{{ route('products.index') }}" class="btn-editorial">Shop Now</a>
    </div>
</div>

    <!-- RIGHT (VIDEO) -->
    <div class="hero-right">
        <div class="hero-video-wrap">

            <video
                class="hero-video"
                src="{{ asset('assets/front-end/vids/teaser.mp4') }}"
                autoplay
                muted
                loop
                playsinline
                preload="auto"></video>

            <!--<div class="hero-new-tag">-->
            <!--    <span class="hero-new-dot"></span> New Arrivals-->
            <!--</div>-->

            <a href="{{ route('products.index') }}" class="hero-shop-btn">Shop Now →</a>

        </div>
    </div>

</section>





<!-- ══════════════════════════════════════
         NEW ARRIVALS
    ══════════════════════════════════════ -->
<section class="section">
    <div class="section-inner">

        <div class="section-header">
<h2 class="section-title">New arrivals</h2>
<!--<a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">View All →</a>-->
            
                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm view-all-desktop">View All →</a>

        </div>

    <div class="products-grid">
    @forelse($newArrivals as $product)
    <a href="{{ route('shop.show', $product['slug'] ?? $product['id']) }}" class="product-card" style="text-decoration:none;color:inherit;display:block">
        <div class="product-img">
            @if($product['featured_image'])
            <img src="{{ $product['featured_image'] }}"
                alt="{{ $product['name'] }}"
                loading="lazy">
            @endif

            {{-- Badges --}}
            @if($product['is_new'])
            <span class="product-badge">New</span>
            @elseif($product['has_discount'])
            <span class="product-badge">Sale</span>
            @elseif($product['is_bestseller'])
            <span class="product-badge">Best</span>
            @endif
        </div>
        <div class="product-info">
            <div class="product-cat">{{ $product['category']['name'] }}</div>
            <div class="product-name">{{ $product['name'] }}</div>
            <div class="product-footer">
                <div class="product-price">
                    @if($product['has_discount'] && $product['current_price'] < $product['regular_price'])
                        <del style="color: var(--grey-400); font-weight: 400;">
                        {{ $product['formatted_regular_price'] }}
                        </del>
                        &nbsp;{{ $product['formatted_current_price'] }}
                        @else
                        {{ $product['formatted_current_price'] }}
                        @endif
                </div>
               <button class="product-add"
    onclick="event.preventDefault(); event.stopPropagation(); addToCart(
                    {{ $product['id'] }},
                    '{{ addslashes($product['name']) }}',
                    {{ $product['current_price'] }},
                    '{{ $product['featured_image'] ?? '' }}',
                    ''
                )"
    aria-label="Add {{ $product['name'] }} to cart">
    <i class="ph ph-shopping-cart" style="color:var(--white);font-size:14px;"></i>
</button>
            </div>
        </div>
    </a>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:64px 40px;
                        border:2px dashed var(--grey-200);">
        <div style="font-family:'DM Mono',monospace;font-size:0.78rem;
                            letter-spacing:0.08em;color:var(--grey-400);margin-bottom:20px;">
            NEW ARRIVALS COMING SOON
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
            Browse All Products
        </a>
    </div>
    @endforelse
</div>

<a href="{{ route('products.index') }}" class="btn btn-outline btn-full view-all-mobile">View All →</a>

    </div>
</section>


<!-- ══════════════════════════════════════
         CATEGORIES
    ══════════════════════════════════════ -->
<section class="section" style="padding-top:0">
    <div class="section-inner">

        <div class="section-header">
<h2 class="section-title">Shop by category</h2>
<span class="section-meta mono">
                {{ str_pad(count($categories), 2, '0', STR_PAD_LEFT) }} COLLECTIONS
            </span>
        </div>

        <div class="cats-grid">
            @forelse($categories as $i => $cat)
            <a href="{{ $cat['url'] }}"
                class="cat-card"
                style="text-decoration:none;color:inherit">
                <div class="cat-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <h3 class="cat-name">{{ strtoupper($cat['name']) }}</h3>
                <p class="cat-count">{{ number_format($cat['products_count']) }} PIECES</p>
                <span class="cat-arrow">↗</span>
            </a>
            @empty
            {{-- Fallback static categories --}}
            @foreach([
            ['Tops', 'tops'], ['Bottoms', 'bottoms'], ['Outerwear', 'outerwear'],
            ['Dresses', 'dresses'], ['Accessories', 'accessories'], ['Footwear', 'footwear'],
            ] as $i => [$name, $slug])
            <a href="{{ route('products.index', ['cat' => $slug]) }}"
                class="cat-card"
                style="text-decoration:none;color:inherit">
                <div class="cat-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                <h3 class="cat-name">{{ strtoupper($name) }}</h3>
                <p class="cat-count">— PIECES</p>
                <span class="cat-arrow">↗</span>
            </a>
            @endforeach
            @endforelse
        </div>

    </div>
</section>


<!-- ══════════════════════════════════════
         PROMO / NEWSLETTER BANNER
    ══════════════════════════════════════ -->
<div class="promo-banner">

    <div class="promo-left">
        <p class="promo-eyebrow">Join the list</p>
        <h2 class="promo-title">EARLY ACCESS.<br>FIRST LOOKS.</h2>
        <p class="promo-text">
            Subscribe for early access to new drops, exclusive offers, and
            behind-the-scenes content. No spam, ever.
        </p>
        <form class="promo-form" method="POST" action=""
            onsubmit="handleNewsletterSubmit(event, this)">
            @csrf
            <input class="promo-input" type="email" name="email"
                placeholder="your@email.com" required>
            <button type="submit" class="promo-submit">Subscribe</button>
        </form>
    </div>

    <div class="promo-right">
        <div class="promo-stats">
            <div>
                <div class="stat-num">48k</div>
                <div class="stat-label">Customers</div>
            </div>
            <div>
                <div class="stat-num">{{ number_format(count($categories)) }}</div>
                <div class="stat-label">Collections</div>
            </div>
            <div>
                <div class="stat-num">99%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
            <div>
                <div class="stat-num">0</div>
                <div class="stat-label">Compromise</div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function handleNewsletterSubmit(e, form) {
        e.preventDefault();
        showToast('You\'re subscribed! Welcome to the list.');
        form.reset();
    }
</script>
@endpush