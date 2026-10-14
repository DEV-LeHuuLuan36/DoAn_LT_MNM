@if ($paginator->hasPages())
    <nav class="d-flex flex-column flex-sm-row justify-content-between align-items-center w-100 gap-2" aria-label="Điều hướng phân trang">
        <div>
            <p class="small text-muted mb-0">
                Hiển thị <span class="fw-bold text-dark">{{ $paginator->firstItem() }}</span> đến <span class="fw-bold text-dark">{{ $paginator->lastItem() }}</span> trong tổng số <span class="fw-bold text-dark">{{ $paginator->total() }}</span> bài đăng
            </p>
        </div>

        <div>
            <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Trang trước</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Trang trước</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link fw-bold">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Trang sau</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Trang sau</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
