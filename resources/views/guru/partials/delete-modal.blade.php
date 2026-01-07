{{-- Delete Confirmation Modal --}}
<div x-show="showDeleteModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
     @click.self="showDeleteModal = false"
     style="display: none;">
    
    <div x-show="showDeleteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
        
        {{-- Modal Content --}}
        <div class="p-8 text-center">
            {{-- Icon --}}
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            {{-- Title --}}
            <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="deleteType === 'single' ? 'Hapus Guru/Staff?' : 'Hapus ' + selectedItems.length + ' Staff?'"></h3>
            
            {{-- Description --}}
            <template x-if="deleteType === 'single'">
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus data <span class="font-semibold text-gray-900" x-text="deleteTarget?.nama_lengkap"></span>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </template>
            <template x-if="deleteType === 'bulk'">
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus <span class="font-semibold text-gray-900" x-text="selectedItems.length"></span> staf yang dipilih? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </template>

            {{-- Warning for self-deletion --}}
            <template x-if="deleteType === 'single' && deleteTarget?.id === currentUserId">
                <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl text-sm text-yellow-800">
                    <strong>Perhatian:</strong> Anda tidak dapat menghapus akun Anda sendiri.
                </div>
            </template>

            {{-- Buttons --}}
            <div class="flex items-center justify-center gap-3">
                <button @click="showDeleteModal = false" 
                        class="px-6 py-3 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button @click="executeDelete()"
                        :disabled="isDeleting || (deleteType === 'single' && deleteTarget?.id === currentUserId)"
                        class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:scale-[1.02] transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <span x-show="!isDeleting" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Ya, Hapus
                    </span>
                    <span x-show="isDeleting" class="flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghapus...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
