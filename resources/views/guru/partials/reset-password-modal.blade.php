{{-- Reset Password Modal --}}
<div x-show="showResetPasswordModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
     @click.self="showResetPasswordModal = false"
     style="display: none;">
    
    <div x-show="showResetPasswordModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
        
        {{-- Modal Header --}}
        <div class="px-8 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Reset Password</h2>
                    <p class="text-sm text-blue-200" x-text="resetPasswordTarget?.nama_lengkap"></p>
                </div>
            </div>
        </div>

        {{-- Modal Body --}}
        <form @submit.prevent="executeResetPassword()" class="p-8">
            <div class="space-y-4">
                {{-- New Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" 
                               x-model="resetPasswordData.new_password" 
                               maxlength="100"
                               :class="resetPasswordErrors.new_password ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-blue-500'"
                               class="w-full px-4 py-3 pr-12 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                               placeholder="Minimal 6 karakter">
                        <button type="button" @click="showPassword = !showPassword" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-red-500 mt-1" x-show="resetPasswordErrors.new_password" x-text="resetPasswordErrors.new_password"></p>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input :type="showPassword ? 'text' : 'password'" 
                           x-model="resetPasswordData.new_password_confirmation" 
                           maxlength="100"
                           :class="resetPasswordErrors.new_password_confirmation ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-blue-500'"
                           class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                           placeholder="Ulangi password baru">
                    <p class="text-xs text-red-500 mt-1" x-show="resetPasswordErrors.new_password_confirmation" x-text="resetPasswordErrors.new_password_confirmation"></p>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium">Perhatian</p>
                        <p class="mt-1">Password baru harus minimal 6 karakter. Aksi ini akan dicatat dalam activity log.</p>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 mt-6">
                <button type="button" @click="closeResetPasswordModal()" 
                        class="px-6 py-3 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        :disabled="isResettingPassword"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:scale-[1.02] transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                    <span x-show="!isResettingPassword" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Reset Password
                    </span>
                    <span x-show="isResettingPassword" class="flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
