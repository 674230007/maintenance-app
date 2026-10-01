<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-700">✍️ สมัครสมาชิก</h2>
        <p class="text-sm text-gray-500">ระบบแจ้งซ่อมออนไลน์ (รหัสผ่านตั้งต้น: 123456)</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('ชื่อ-นามสกุล')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="กรอกชื่อ-นามสกุล" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('อีเมล (Email)')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="กรอกอีเมล" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('เลือกบทบาทสิทธิ์การใช้งาน')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="user">👤 ผู้ใช้งานทั่วไป (User)</option>
                <option value="technician">🔧 ช่างซ่อมบำรุง (Technician)</option>
                <option value="admin">⚙️ ผู้ดูแลระบบ (Admin)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- ซ่อนช่องรหัสผ่านและตั้งค่าเป็น 123456 อัตโนมัติ -->
        <input type="hidden" name="password" value="123456">
        <input type="hidden" name="password_confirmation" value="123456">

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('มีบัญชีอยู่แล้ว? เข้าสู่ระบบ') }}
            </a>

            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                {{ __('สมัครสมาชิก') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>