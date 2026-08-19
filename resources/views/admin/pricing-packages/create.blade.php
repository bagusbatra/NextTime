<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Paket Harga</h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm ring-1 ring-gray-200 rounded-xl p-6">
                <form method="POST" action="{{ route('admin.pricing-packages.store') }}">
                    @csrf
                    @include('admin.pricing-packages._form', ['package' => $package])
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
