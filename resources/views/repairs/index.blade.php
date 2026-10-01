<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">🛠️ ระบบแจ้งซ่อมและติดตามสถานะออนไลน์</h2>
            <span class="bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full">
                สถานะสิทธิ์: {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- 📌 ฝั่งซ้าย: ฟอร์มแจ้งซ่อม -->
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📝 แบบฟอร์มแจ้งซ่อมอุปกรณ์
                </h3>
                
                <form action="{{ route('repairs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-medium text-gray-700 text-sm mb-1">หัวข้อปัญหา / อุปกรณ์ *</label>
                        <input type="text" name="title" placeholder="เช่น แอร์ห้องประชุม 101 ไม่เย็น, คอมพิวเตอร์เปิดไม่ติด" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-sm mb-1">รายละเอียดปัญหาเพิ่มเติม *</label>
                        <textarea name="description" rows="3" placeholder="ระบุอาการ อาคาร หรือจุดที่ตั้งให้ชัดเจน..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 text-sm mb-1">แนบรูปภาพประกอบ (ถ้ามี)</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg">
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold py-3 px-4 rounded-lg shadow hover:from-orange-600 hover:to-amber-600 transition">
                        🚀 ส่งคำขอแจ้งซ่อม
                    </button>
                </form>
            </div>

            <!-- 📌 ฝั่งขวา: ติดตามสถานะการแจ้งซ่อม -->
            <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-100 flex flex-col h-[600px]">
                <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📋 ติดตามสถานะการแจ้งซ่อม
                </h3>

                <div class="overflow-y-auto flex-1 space-y-3 pr-2">
                    @forelse($repairs as $repair)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-800 text-base">{{ $repair->title }}</h4>
                                    
                                    @php
                                        $statusColor = match($repair->status) {
                                            'รอดำเนินการ' => 'bg-yellow-100 text-yellow-800',
                                            'กำลังซ่อม' => 'bg-blue-100 text-blue-800',
                                            'ซ่อมเสร็จสิ้น' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColor }}">
                                        {{ $repair->status }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mt-1">{{ $repair->description }}</p>
                                <p class="text-xs text-gray-400 mt-2">ผู้แจ้ง: {{ $repair->user->name }} | เมื่อ: {{ $repair->created_at->diffForHumans() }}</p>
                            </div>

                            <!-- เปลี่ยนสถานะ (แสดงเฉพาะ Admin หรือ ช่าง) -->
                            @if(in_array(Auth::user()->role, ['admin', 'technician']))
                                <div class="mt-3 pt-3 border-t border-gray-200 flex justify-end">
                                    <form action="{{ route('repairs.updateStatus', $repair->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="text-xs font-medium text-gray-500">เปลี่ยนสถานะ:</label>
                                        <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="รอดำเนินการ" {{ $repair->status == 'รอดำเนินการ' ? 'selected' : '' }}>รอดำเนินการ</option>
                                            <option value="กำลังซ่อม" {{ $repair->status == 'กำลังซ่อม' ? 'selected' : '' }}>กำลังซ่อม</option>
                                            <option value="ซ่อมเสร็จสิ้น" {{ $repair->status == 'ซ่อมเสร็จสิ้น' ? 'selected' : '' }}>ซ่อมเสร็จสิ้น</option>
                                        </select>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-16 text-gray-400">
                            <p>ยังไม่มีรายการแจ้งซ่อมในระบบ</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>