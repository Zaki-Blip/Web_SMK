@props(['items', 'id' => 'faq-accordion'])

@if ($items->isNotEmpty())
    <div class="accordion" id="{{ $id }}">
        @foreach ($items as $index => $faq)
            <div class="accordion-item">
                <h3 class="accordion-header" id="{{ $id }}-heading-{{ $faq->id }}">
                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#{{ $id }}-collapse-{{ $faq->id }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="{{ $id }}-collapse-{{ $faq->id }}">
                        {{ $faq->pertanyaan }}
                    </button>
                </h3>
                <div id="{{ $id }}-collapse-{{ $faq->id }}"
                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                     aria-labelledby="{{ $id }}-heading-{{ $faq->id }}"
                     data-bs-parent="#{{ $id }}">
                    <div class="accordion-body">
                        {!! nl2br(e($faq->jawaban)) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <x-empty-state
        icon="bi-question-circle"
        title="Belum ada FAQ"
        message="Pertanyaan yang sering diajukan akan tampil setelah pihak sekolah menambahkannya."
    />
@endif
