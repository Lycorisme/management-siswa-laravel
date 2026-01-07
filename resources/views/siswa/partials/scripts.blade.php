<script>
function siswaApp() {
    return {
        // State
        loading: false,
        siswaList: [],
        stats: {},
        pagination: {},
        selectedItems: [],
        selectAll: false,

        // Modal states
        showFormModal: false,
        showDetailModal: false,
        showDeleteModal: false,

        // Form state
        isEditMode: false,
        editId: null,
        isSubmitting: false,
        activeTab: 'pribadi',
        formData: {},
        formErrors: {},
        fotoFile: null,
        fotoPreview: null,

        // Detail state
        detailData: {},

        // Delete state
        deleteType: 'single', // 'single' or 'bulk'
        deleteTarget: null,
        isDeleting: false,

        // Filters
        filters: {
            search: '',
            kelas_id: '',
            status: '',
            jenis_kelamin: '',
            per_page: 10,
            page: 1,
            sort_by: 'nama_lengkap',
            sort_order: 'asc'
        },

        // Initialize
        init() {
            this.fetchData();
        },

        // Fetch data from API
        async fetchData() {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: this.filters.page,
                    per_page: this.filters.per_page,
                    search: this.filters.search,
                    kelas_id: this.filters.kelas_id,
                    status: this.filters.status,
                    jenis_kelamin: this.filters.jenis_kelamin,
                    sort_by: this.filters.sort_by,
                    sort_order: this.filters.sort_order
                });

                const response = await fetch(`/api/siswa?${params}`);
                const result = await response.json();

                if (result.success) {
                    this.siswaList = result.data.data;
                    this.stats = result.stats;
                    this.pagination = {
                        current_page: result.data.current_page,
                        last_page: result.data.last_page,
                        from: result.data.from,
                        to: result.data.to,
                        total: result.data.total
                    };
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                this.showToast('error', 'Gagal memuat data siswa');
            } finally {
                this.loading = false;
            }
        },

        // Sort by column
        sortBy(column) {
            if (this.filters.sort_by === column) {
                this.filters.sort_order = this.filters.sort_order === 'asc' ? 'desc' : 'asc';
            } else {
                this.filters.sort_by = column;
                this.filters.sort_order = 'asc';
            }
            this.fetchData();
        },

        // Toggle select all
        toggleSelectAll() {
            if (this.selectAll) {
                this.selectedItems = this.siswaList.map(s => s.id);
            } else {
                this.selectedItems = [];
            }
        },

        // Pagination
        get paginationPages() {
            const pages = [];
            const current = this.pagination.current_page;
            const last = this.pagination.last_page;

            if (last <= 7) {
                for (let i = 1; i <= last; i++) pages.push(i);
            } else {
                if (current <= 3) {
                    for (let i = 1; i <= 5; i++) pages.push(i);
                    pages.push('...');
                    pages.push(last);
                } else if (current >= last - 2) {
                    pages.push(1);
                    pages.push('...');
                    for (let i = last - 4; i <= last; i++) pages.push(i);
                } else {
                    pages.push(1);
                    pages.push('...');
                    for (let i = current - 1; i <= current + 1; i++) pages.push(i);
                    pages.push('...');
                    pages.push(last);
                }
            }
            return pages;
        },

        goToPage(page) {
            if (page < 1 || page > this.pagination.last_page) return;
            this.filters.page = page;
            this.fetchData();
        },

        // Open create modal
        openCreateModal() {
            this.resetForm();
            this.isEditMode = false;
            this.editId = null;
            this.activeTab = 'pribadi';
            this.showFormModal = true;
            document.body.style.overflow = 'hidden';
        },

        // Open edit modal
        async openEditModal(id) {
            this.resetForm();
            this.isEditMode = true;
            this.editId = id;
            this.activeTab = 'pribadi';

            try {
                const response = await fetch(`/api/siswa/${id}`);
                const result = await response.json();

                if (result.success) {
                    this.formData = { ...result.data };
                    if (result.data.foto_url && result.data.foto) {
                        this.fotoPreview = result.data.foto_url;
                    }
                    this.showFormModal = true;
                    document.body.style.overflow = 'hidden';
                } else {
                    this.showToast('error', result.message || 'Gagal memuat data siswa');
                }
            } catch (error) {
                console.error('Error fetching siswa:', error);
                this.showToast('error', 'Gagal memuat data siswa');
            }
        },

        // Close form modal
        closeFormModal() {
            this.showFormModal = false;
            document.body.style.overflow = '';
            this.resetForm();
        },

        // Reset form
        resetForm() {
            this.formData = {
                nis: '',
                nisn: '',
                nama_lengkap: '',
                jenis_kelamin: 'L',
                tempat_lahir: '',
                tanggal_lahir: '',
                agama: '',
                alamat: '',
                rt_rw: '',
                kelurahan: '',
                kecamatan: '',
                kota: '',
                provinsi: '',
                kode_pos: '',
                no_telepon: '',
                email: '',
                nama_ayah: '',
                nama_ibu: '',
                pekerjaan_ayah: '',
                pekerjaan_ibu: '',
                no_telepon_ortu: '',
                kelas_id: '',
                status: 'aktif',
                tahun_masuk: new Date().getFullYear(),
                tahun_keluar: '',
                total_poin_prestasi: 0,
                total_poin_pelanggaran: 0
            };
            this.formErrors = {};
            this.fotoFile = null;
            this.fotoPreview = null;
        },

        // Handle foto change
        handleFotoChange(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file type
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                this.formErrors.foto = 'Format file harus JPG atau PNG';
                return;
            }

            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                this.formErrors.foto = 'Ukuran file maksimal 2MB';
                return;
            }

            this.fotoFile = file;
            this.formErrors.foto = '';

            // Create preview
            const reader = new FileReader();
            reader.onload = (e) => {
                this.fotoPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        // Remove foto
        removeFoto() {
            this.fotoFile = null;
            this.fotoPreview = null;
            if (this.$refs.fotoInput) {
                this.$refs.fotoInput.value = '';
            }
        },

        // Submit form
        async submitForm() {
            this.isSubmitting = true;
            this.formErrors = {};

            try {
                const formData = new FormData();

                // Append all form fields
                for (const [key, value] of Object.entries(this.formData)) {
                    if (value !== null && value !== undefined && value !== '') {
                        formData.append(key, value);
                    }
                }

                // Append foto file if exists
                if (this.fotoFile) {
                    formData.append('foto', this.fotoFile);
                }

                const url = this.isEditMode ? `/api/siswa/${this.editId}` : '/api/siswa';
                
                // For PUT requests with files, use POST with _method
                if (this.isEditMode) {
                    formData.append('_method', 'PUT');
                }

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    this.showToast('success', result.message);
                    this.closeFormModal();
                    this.fetchData();
                } else {
                    if (result.errors) {
                        this.formErrors = {};
                        for (const [key, messages] of Object.entries(result.errors)) {
                            this.formErrors[key] = messages[0];
                        }
                    } else {
                        this.showToast('error', result.message || 'Terjadi kesalahan');
                    }
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                this.showToast('error', 'Gagal menyimpan data');
            } finally {
                this.isSubmitting = false;
            }
        },

        // View detail
        async viewDetail(id) {
            try {
                const response = await fetch(`/api/siswa/${id}`);
                const result = await response.json();

                if (result.success) {
                    this.detailData = result.data;
                    this.showDetailModal = true;
                    document.body.style.overflow = 'hidden';
                } else {
                    this.showToast('error', result.message || 'Gagal memuat detail siswa');
                }
            } catch (error) {
                console.error('Error fetching detail:', error);
                this.showToast('error', 'Gagal memuat detail siswa');
            }
        },

        // Confirm delete single
        confirmDelete(siswa) {
            this.deleteType = 'single';
            this.deleteTarget = siswa;
            this.showDeleteModal = true;
        },

        // Confirm bulk delete
        confirmBulkDelete() {
            if (this.selectedItems.length === 0) return;
            this.deleteType = 'bulk';
            this.deleteTarget = null;
            this.showDeleteModal = true;
        },

        // Execute delete
        async executeDelete() {
            this.isDeleting = true;

            try {
                let response;

                if (this.deleteType === 'single') {
                    response = await fetch(`/api/siswa/${this.deleteTarget.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Content-Type': 'application/json'
                        }
                    });
                } else {
                    response = await fetch('/api/siswa/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ ids: this.selectedItems })
                    });
                }

                const result = await response.json();

                if (result.success) {
                    this.showToast('success', result.message);
                    this.showDeleteModal = false;
                    this.selectedItems = [];
                    this.selectAll = false;
                    this.fetchData();
                } else {
                    this.showToast('error', result.message || 'Gagal menghapus');
                }
            } catch (error) {
                console.error('Error deleting:', error);
                this.showToast('error', 'Gagal menghapus data');
            } finally {
                this.isDeleting = false;
            }
        },

        // Toast notification (using SweetAlert2)
        showToast(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }
    };
}
</script>
