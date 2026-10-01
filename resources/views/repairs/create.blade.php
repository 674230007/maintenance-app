<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">ฟอร์มแจ้งซ่อมอุปกรณ์</h2>
    </x-slot>
    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('repairs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium">หัวข้อปัญหา:</label>
                    <input type="text" name="title" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">รายละเอียดเพิ่มเติม:</label>
                    <textarea name="description" class="w-full border rounded p-2" rows="4" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">แนบรูปภาพ (ถ้ามี):</label>
                    <input type="file" name="image" class="w-full border rounded p-2">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">บันทึกการแจ้งซ่อม</button>
            </form>
        </div>
    </div>
</x-app-layout>