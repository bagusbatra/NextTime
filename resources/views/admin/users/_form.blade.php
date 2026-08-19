<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="name" value="Nama" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $user->name)" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $user->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="role" value="Role" />
        <select id="role" name="role" required
                class="mt-1 block w-full border-gray-300 focus:border-cyan-500 focus:ring-cyan-500 rounded-md shadow-sm">
            @foreach (['user' => 'Pengguna Biasa', 'admin' => 'Admin'] as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user->role ?? 'user') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-gray-400">Hanya role "Admin" yang bisa mengakses panel ini.</p>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>

    <div></div>

    <div>
        <x-input-label for="password" :value="$user->exists ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi'" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                      autocomplete="new-password" :required="! $user->exists" />
        @if ($user->exists)
            <p class="mt-1 text-xs text-gray-400">Kosongkan bila tidak ingin mengubah kata sandi.</p>
        @endif
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"
                      autocomplete="new-password" :required="! $user->exists" />
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">Batal</a>
</div>
