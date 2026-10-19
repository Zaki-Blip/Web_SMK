@props(['items'])

@php
    $modalId = 'galeri-'.uniqid();
@endphp

<div class="row g-3">
    @foreach ($items as $item)
        <div class="col-6 col-md-4 col-lg-3">
            <figure class="tk-card h-100 mb-0 d-flex flex-column">
                @if ($item->imageUrl())
                    <button type="button" class="btn p-0 border-0" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"
                            data-lightbox-src="{{ $item->imageUrl() }}"
                            data-lightbox-title="{{ $item->title }}"
                            data-lightbox-caption="{{ $item->caption }}"
                            aria-label="Perbesar foto: {{ $item->title }}">
                        <x-public.media :url="$item->imageUrl()" :alt="$item->title" icon="bi-images" />
                    </button>
                @else
                    <x-public.media :url="null" :alt="$item->title" icon="bi-images" />
                @endif

                <figcaption class="p-2">
                    <span class="d-block fw-semibold small">{{ $item->title }}</span>

                    @if (filled($item->category))
                        <span class="tk-badge mt-1">{{ $item->category }}</span>
                    @endif

                    @if (filled($item->caption))
                        <span class="d-block text-muted-soft mt-1" style="font-size: .8125rem;">
                            {{ \Illuminate\Support\Str::limit($item->caption, 80) }}
                        </span>
                    @endif
                </figcaption>
            </figure>
        </div>
    @endforeach
</div>

{{-- Lightbox sederhana memakai modal Bootstrap --}}
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title h6" id="{{ $modalId }}-label" data-lightbox-title-target></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="" class="img-fluid" data-lightbox-image>
                <p class="text-muted-soft mt-3 mb-0" data-lightbox-caption-target></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('{{ $modalId }}');

        if (!modal) {
            return;
        }

        modal.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;

            if (!trigger) {
                return;
            }

            var image = modal.querySelector('[data-lightbox-image]');
            var title = modal.querySelector('[data-lightbox-title-target]');
            var caption = modal.querySelector('[data-lightbox-caption-target]');

            var src = trigger.getAttribute('data-lightbox-src') || '';
            var text = trigger.getAttribute('data-lightbox-title') || '';

            image.setAttribute('src', src);
            image.setAttribute('alt', text);
            title.textContent = text;
            caption.textContent = trigger.getAttribute('data-lightbox-caption') || '';
        });
    });
</script>
