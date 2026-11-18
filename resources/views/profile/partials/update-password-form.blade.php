<section>
    <header class="mb-4">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-lock text-[#6C5DD3]"></i> Ubah Password
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password Saat Ini</label>
            <input type="password" name="current_password" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" autocomplete="current-password">
            @if($errors->updatePassword->get('current_password'))
                <span class="text-red-500 text-xs mt-1 block">{{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password Baru</label>
            <input type="password" name="password" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" autocomplete="new-password">
            @if($errors->updatePassword->get('password'))
                <span class="text-red-500 text-xs mt-1 block">{{ $errors->updatePassword->first('password') }}</span>
            @endif
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#6C5DD3] bg-gray-50" autocomplete="new-password">
            @if($errors->updatePassword->get('password_confirmation'))
                <span class="text-red-500 text-xs mt-1 block">{{ $errors->updatePassword->first('password_confirmation') }}</span>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all">Simpan Password</button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 font-medium">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>