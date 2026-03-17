{{--
  Generic form modal wrapper.
  Usage:
    <x-app-modal id="myModal" title="Tambah Data">
        <form ...> ... </form>
    </x-app-modal>

  Props:
    id       (required) — modal ID
    title    (required) — modal header title
    size     (optional) — 'sm' | 'lg' | 'xl'  (default: none = medium)
    icon     (optional) — FontAwesome class, e.g. "fas fa-plus"
--}}
@props(['id', 'title', 'size' => null, 'icon' => null])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $size ? 'modal-'.$size : '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    @if($icon)
                        <span style="width:28px;height:28px;background:rgba(59,130,246,0.1);border-radius:7px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="{{ $icon }}" style="font-size:12px;color:#3b82f6;"></i>
                        </span>
                    @endif
                    <h5 class="modal-title">{{ $title }}</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
