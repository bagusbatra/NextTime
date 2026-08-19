@props(['action', 'on' => false, 'label' => 'Ubah status'])

<form method="POST" action="{{ $action }}" class="inline-flex">
    @csrf
    @method('PATCH')
    <button
        type="submit"
        class="admin-switch"
        data-on="{{ $on ? 'true' : 'false' }}"
        aria-pressed="{{ $on ? 'true' : 'false' }}"
        aria-label="{{ $label }}"
        title="{{ $label }}"
    >
        <span class="admin-switch-dot"></span>
    </button>
</form>
