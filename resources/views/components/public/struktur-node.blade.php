@props(['node', 'level' => 0])

<div class="tk-org-node {{ $level > 0 ? 'tk-org-node-child' : '' }}">
    <div class="tk-card p-3">
        <p class="tk-badge mb-2">{{ $node->jabatan }}</p>
        <h3 class="h6 mb-0">{{ $node->nama }}</h3>
    </div>

    @if ($node->children->isNotEmpty())
        <div class="row g-2 mt-1">
            @foreach ($node->children as $child)
                <div class="col-md-6">
                    <x-public.struktur-node :node="$child" :level="$level + 1" />
                </div>
            @endforeach
        </div>
    @endif
</div>
