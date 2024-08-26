@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center" style="display: flex; justify-content: center; align-items: center; gap: 5px;">
        <ul class="pagination" style="display: flex; justify-content: center; align-items: center; gap: 5px; list-style: none; padding: 0; margin: 0;">
            {{-- Lien vers la page précédente --}}
            @if ($paginator->onFirstPage())
                <li class="page-item" style="margin: 0 2px;">
                    <button class="page-link" style="padding: 0.5rem 1rem; background-color: #e9ecef; color: #6c757d; border: 1px solid #e9ecef; border-radius: 5px;" disabled>⟨ Précédent</button>
                </li>
            @else
                <li class="page-item" style="margin: 0 2px;">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding: 0.5rem 1rem; background-color: #007bff; color: #fff; border: 1px solid #007bff; border-radius: 5px;">⟨ Précédent</a>
                </li>
            @endif

            {{-- Liens de pages dynamiques --}}
            @php
                $start = max(1, $paginator->currentPage() - 2);
                $end = min($start + 4, $paginator->lastPage());

                if ($start > 1) {
                    echo '<li class="page-item" style="margin: 0 2px;"><a class="page-link" href="' . $paginator->url(1) . '" style="padding: 0.5rem 1rem; border-radius: 5px;">1</a></li>';
                    if ($start > 2) {
                        echo '<li class="page-item" style="margin: 0 2px;"><span class="page-link" style="padding: 0.5rem 1rem; border-radius: 5px;">...</span></li>';
                    }
                }
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page" style="margin: 0 2px;">
                        <span class="page-link" style="padding: 0.5rem 1rem; background-color: #007bff; color: #fff; border: 1px solid #007bff; border-radius: 5px;">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item" style="margin: 0 2px;">
                        <a class="page-link" href="{{ $paginator->url($page) }}" style="padding: 0.5rem 1rem; border-radius: 5px;">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            @php
                if ($end < $paginator->lastPage()) {
                    if ($end < $paginator->lastPage() - 1) {
                        echo '<li class="page-item" style="margin: 0 2px;"><span class="page-link" style="padding: 0.5rem 1rem; border-radius: 5px;">...</span></li>';
                    }
                    echo '<li class="page-item" style="margin: 0 2px;"><a class="page-link" href="' . $paginator->url($paginator->lastPage()) . '" style="padding: 0.5rem 1rem; border-radius: 5px;">' . $paginator->lastPage() . '</a></li>';
                }
            @endphp

            {{-- Lien vers la page suivante --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" style="margin: 0 2px;">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding: 0.5rem 1rem; background-color: #007bff; color: #fff; border: 1px solid #007bff; border-radius: 5px;">Suivant ⟩</a>
                </li>
            @else
                <li class="page-item" style="margin: 0 2px;">
                    <button class="page-link" style="padding: 0.5rem 1rem; background-color: #e9ecef; color: #6c757d; border: 1px solid #e9ecef; border-radius: 5px;" disabled>Suivant ⟩</button>
                </li>
            @endif
        </ul>
    </nav>
@endif
