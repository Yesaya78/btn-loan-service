<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold mb-4">Buat Laporan Pengaduan</h2>
                
                @if(session('success'))
                    <div class="bg-green-100 p-3 mb-4 text-green-700 rounded">{{ session('success') }}</div>
                @endif

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label>Judul Laporan</label>
                        <input type="text" name="judul" class="w-full border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label>Isi Laporan</label>
                        <textarea name="isi_laporan" class="w-full border-gray-300 rounded" rows="5" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label>Foto Bukti (Opsional)</label>
                        <input type="file" name="foto" class="w-full">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>