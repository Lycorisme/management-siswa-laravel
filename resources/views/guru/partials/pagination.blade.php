{{-- Pagination --}}
<div class="px-6 py-4 border-t border-gray-100">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        {{-- Info --}}
        <div class="text-sm text-gray-600">
            <span>Menampilkan </span>
            <span class="font-semibold" x-text="pagination.from || 0"></span>
            <span> - </span>
            <span class="font-semibold" x-text="pagination.to || 0"></span>
            <span> dari </span>
            <span class="font-semibold" x-text="pagination.total || 0"></span>
            <span> staf</span>
        </div>

        {{-- Pagination Buttons --}}
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            <button @click="goToPage(pagination.current_page - 1)"
                    :disabled="pagination.current_page === 1"
                    :class="pagination.current_page === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-100 hover:text-indigo-600'"
                    class="p-2 rounded-lg text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            {{-- Page Numbers --}}
            <template x-for="page in paginationPages" :key="page">
                <button @click="page !== '...' && goToPage(page)"
                        :disabled="page === '...'"
                        :class="{
                            'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30': page === pagination.current_page,
                            'hover:bg-indigo-100 hover:text-indigo-600 text-gray-600': page !== pagination.current_page && page !== '...',
                            'cursor-default': page === '...'
                        }"
                        class="w-10 h-10 rounded-lg font-medium transition-all"
                        x-text="page">
                </button>
            </template>

            {{-- Next --}}
            <button @click="goToPage(pagination.current_page + 1)"
                    :disabled="pagination.current_page === pagination.last_page"
                    :class="pagination.current_page === pagination.last_page ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-100 hover:text-indigo-600'"
                    class="p-2 rounded-lg text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
