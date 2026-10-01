<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-700">🛠️ เข้าสู่ระบบแจ้งซ่อม</h2>
        <p class="text-sm text-gray-500 mt-1">ใช้ชื่อผู้ใช้งานและรหัสผ่าน (123456)</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- ชื่อผู้ใช้งาน -->
        <div>
            <x-input-label for="name" :value="__('ชื่อผู้ใช้งาน (Name)')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="กรอกชื่อผู้ใช้งาน" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- รหัสผ่าน -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('รหัสผ่าน (Password)')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required value="123456" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- ปุ่มเข้าสู่ระบบ -->
        <div class="mt-6">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 py-3 text-base">
                {{ __('เข้าสู่ระบบ') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>