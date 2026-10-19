@props([
    'id' => 'confirm-delete',
    'title' => 'Hapus data ini?',
    'message' => 'Data yang dihapus tidak dapat dikembalikan.',
    'confirmLabel' => 'Ya, hapus',
])

{{-- Satu modal per halaman; aksi dan nama data diisi dari tombol pemicu (data-delete-*). --}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" data-confirm-form>
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h2 class="modal-title h6" id="{{ $id }}-label">{{ $title }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">{{ $message }}</p>
                    <p class="mb-0 fw-semibold" data-confirm-name></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-tk-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">{{ $confirmLabel }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('{{ $id }}');

        if (!modal) {
            return;
        }

        modal.addEventListener('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;

            if (!trigger) {
                return;
            }

            var form = modal.querySelector('[data-confirm-form]');
            var name = modal.querySelector('[data-confirm-name]');

            form.setAttribute('action', trigger.getAttribute('data-delete-url') || '');
            name.textContent = trigger.getAttribute('data-delete-label') || '';
        });
    });
</script>
