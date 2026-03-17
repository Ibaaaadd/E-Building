{{-- Usage: <x-pdf-modal id="modalId" title="Surat Laporan" src="{{ asset('path/file.pdf') }}" /> --}}
@props(['id', 'title', 'src'])

<div class="modal fade pdf-viewer" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background:#f8fafc !important;">
                <div class="d-flex align-items-center gap-2">
                    <span style="width:30px;height:30px;background:#fee2e2;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-file-pdf" style="font-size:13px;color:#dc2626;"></i>
                    </span>
                    <span class="modal-title">{{ $title }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ $src }}" download
                        class="btn btn-sm"
                        style="font-size:12px;border-radius:7px !important;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;">
                        <i class="fas fa-download me-1"></i>Unduh
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-0">
                <embed src="{{ $src }}" type="application/pdf" width="100%" height="620"
                    style="display:block;border-radius:0 0 16px 16px;border:none;">
            </div>
        </div>
    </div>
</div>
