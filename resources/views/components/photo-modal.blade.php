{{-- Usage: <x-photo-modal id="modalId" title="Judul" src="{{ asset('path/foto.jpg') }}" /> --}}
@props(['id', 'title', 'src', 'alt' => ''])

<div class="modal fade photo-lightbox" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header" style="background:#1e293b !important; border-bottom:1px solid #334155 !important;">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:28px;height:28px;background:rgba(59,130,246,0.2);border-radius:7px;display:inline-flex;align-items:center;justify-content:center;">
                        <i class="fas fa-image" style="font-size:12px;color:#60a5fa;"></i>
                    </span>
                    <span class="modal-title" style="color:#f1f5f9 !important;">{{ $title }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ $src }}" download
                        class="btn-icon btn-icon-info"
                        title="Unduh Foto"
                        style="text-decoration:none;">
                        <i class="fas fa-download"></i>
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-0" style="background:#0f172a;border-radius:0 0 16px 16px;overflow:hidden;">
                <img src="{{ $src }}" alt="{{ $alt }}"
                    style="width:100%;max-height:72vh;object-fit:contain;display:block;">
            </div>
        </div>
    </div>
</div>
