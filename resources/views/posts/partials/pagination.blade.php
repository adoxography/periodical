<div class="post-pagination">
    <div class="post-pagination__left">
        @if (!$paginator->onFirstPage())
            <a
                class="post-pagination__link post-pagination__link--left"
                href="{{ $paginator->previousPageUrl() }}"
                aria-label="Previous page"
            >
                <svg class="post-pagination__icon post-pagination__icon--left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 2.5V6h7v8h-7v3.5L2.5 10 10 2.5z"/></svg>
                Previous page
            </a>
        @endif
    </div>

    <div class="post-pagination__right">
        @if ($paginator->hasMorePages())
            <a
                class="post-pagination__link post-pagination__link--right"
                href="{{ $paginator->nextPageUrl() }}"
                aria-label="Next page"
            >
                Next page
                <svg class="post-pagination__icon post-pagination__icon--right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17.5 10L10 17.5V14H3V6h7V2.5l7.5 7.5z"/></svg>
            </a>
        @endif
    </div>
</div>
