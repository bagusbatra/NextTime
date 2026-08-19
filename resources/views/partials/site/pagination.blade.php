{{-- Pagination bergaya tema publik (bukan Tailwind admin) --}}
@if ($paginator->hasPages())
  <nav class="pagination" aria-label="Navigasi halaman">
    @if ($paginator->onFirstPage())
      <span class="pagination-link pagination-link--disabled" aria-disabled="true">
        <i data-lucide="chevron-left"></i>
      </span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link" rel="prev" aria-label="Halaman sebelumnya">
        <i data-lucide="chevron-left"></i>
      </a>
    @endif

    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="pagination-link pagination-link--dots">{{ $element }}</span>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="pagination-link pagination-link--active" aria-current="page">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link" rel="next" aria-label="Halaman berikutnya">
        <i data-lucide="chevron-right"></i>
      </a>
    @else
      <span class="pagination-link pagination-link--disabled" aria-disabled="true">
        <i data-lucide="chevron-right"></i>
      </span>
    @endif
  </nav>
@endif
