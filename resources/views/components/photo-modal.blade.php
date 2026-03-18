{{-- Usage: <x-photo-modal id="modalId" title="Judul" src="{{ asset('path/foto.jpg') }}" /> --}}
@props(['id', 'title', 'src', 'alt' => ''])

<div class="modal fade photo-lightbox" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border:none;border-radius:18px;overflow:hidden;background:#0f172a;box-shadow:0 24px 64px rgba(0,0,0,.5);">

            {{-- Header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:#1e293b;border-bottom:1px solid #334155;gap:12px;">
                {{-- Left: icon + title --}}
                <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                    <span style="width:34px;height:34px;background:rgba(99,102,241,.18);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-image" style="font-size:14px;color:#818cf8;"></i>
                    </span>
                    <span style="font-size:13px;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $title }}</span>
                </div>
                {{-- Right: download + close --}}
                <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                    <a href="{{ $src }}" download
                        title="Unduh Foto"
                        style="width:34px;height:34px;border-radius:9px;background:rgba(99,102,241,.18);color:#818cf8;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:background .15s;"
                        onmouseover="this.style.background='rgba(99,102,241,.35)'"
                        onmouseout="this.style.background='rgba(99,102,241,.18)'">
                        <i class="fas fa-download" style="font-size:13px;"></i>
                    </a>
                    <button type="button" data-bs-dismiss="modal"
                        title="Tutup"
                        style="width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,.07);border:none;color:#94a3b8;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s,color .15s;"
                        onmouseover="this.style.background='rgba(239,68,68,.25)';this.style.color='#f87171'"
                        onmouseout="this.style.background='rgba(255,255,255,.07)';this.style.color='#94a3b8'">
                        <i class="fas fa-times" style="font-size:14px;"></i>
                    </button>
                </div>
            </div>

            {{-- Image --}}
            <div style="background:#0f172a;border-radius:0 0 18px 18px;overflow:hidden;display:flex;align-items:center;justify-content:center;min-height:200px;">
                <img src="{{ $src }}" alt="{{ $alt }}"
                    style="width:100%;max-height:75vh;object-fit:contain;display:block;">
            </div>

        </div>
    </div>
</div>
