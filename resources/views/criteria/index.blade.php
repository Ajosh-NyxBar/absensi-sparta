@extends('layouts.modern')

@section('title', 'Kriteria SAW')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-tasks text-white text-xl"></i>
                    </div>
                    Manajemen Kriteria SAW
                </h1>
                <p class="text-gray-600 mt-2">Kelola kriteria penilaian Simple Additive Weighting untuk siswa dan guru</p>
            </div>
            <a href="{{ route('criteria.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus"></i>
                <span>Tambah Kriteria</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-green-800 flex-1">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
        <p class="text-red-800 flex-1">{{ session('error') }}</p>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Info Alert -->
    <div class="mb-8 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
            <div class="flex-1">
                <p class="text-gray-800"><strong>Informasi:</strong> Total bobot semua kriteria harus sama dengan <strong class="text-blue-600">1.0</strong> (100%). Gunakan tombol <strong class="text-blue-600">Normalisasi</strong> untuk menyesuaikan bobot secara otomatis.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Student Criteria -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-user-graduate"></i>
                        Kriteria Siswa
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-sm font-semibold">
                            Total: {{ number_format($studentTotalWeight, 2) }}
                        </span>
                        @if($studentTotalWeight != 1.0)
                        <form action="{{ route('criteria.normalize') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="type" value="student">
                            <button type="submit" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-1" title="Normalisasi Bobot">
                                <i class="fas fa-balance-scale text-xs"></i>
                                <span>Normalisasi</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($studentCriteria->isEmpty())
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Belum ada kriteria untuk siswa</p>
                    <a href="{{ route('criteria.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200">
                        <i class="fas fa-plus"></i>
                        Tambah Kriteria Siswa
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Nama Kriteria</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Bobot</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($studentCriteria as $criteria)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4">
                                    <span class="font-mono font-bold text-blue-600">{{ $criteria->code }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-gray-900">{{ $criteria->name }}</div>
                                    @if($criteria->description)
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($criteria->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @if($criteria->type === 'benefit')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-plus-circle"></i>
                                        Benefit
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-minus-circle"></i>
                                        Cost
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-bold text-gray-900">{{ number_format($criteria->weight, 2) }}</div>
                                    <div class="text-xs text-gray-500">({{ number_format($criteria->weight * 100, 0) }}%)</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('criteria.edit', $criteria) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form action="{{ route('criteria.destroy', $criteria) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200" title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-gray-200">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-900">Total Bobot:</td>
                                <td class="px-4 py-4">
                                    <span class="font-bold text-lg {{ $studentTotalWeight == 1.0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($studentTotalWeight, 2) }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>

        <!-- Teacher Criteria -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Kriteria Guru
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-sm font-semibold">
                            Total: {{ number_format($teacherTotalWeight, 2) }}
                        </span>
                        @if($teacherTotalWeight != 1.0)
                        <form action="{{ route('criteria.normalize') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="type" value="teacher">
                            <button type="submit" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-1" title="Normalisasi Bobot">
                                <i class="fas fa-balance-scale text-xs"></i>
                                <span>Normalisasi</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($teacherCriteria->isEmpty())
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Belum ada kriteria untuk guru</p>
                    <a href="{{ route('criteria.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200">
                        <i class="fas fa-plus"></i>
                        Tambah Kriteria Guru
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Nama Kriteria</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Bobot</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($teacherCriteria as $criteria)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-4">
                                    <span class="font-mono font-bold text-green-600">{{ $criteria->code }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-gray-900">{{ $criteria->name }}</div>
                                    @if($criteria->description)
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($criteria->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @if($criteria->type === 'benefit')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-plus-circle"></i>
                                        Benefit
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-minus-circle"></i>
                                        Cost
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-bold text-gray-900">{{ number_format($criteria->weight, 2) }}</div>
                                    <div class="text-xs text-gray-500">({{ number_format($criteria->weight * 100, 0) }}%)</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('criteria.edit', $criteria) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <form action="{{ route('criteria.destroy', $criteria) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-200" title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-gray-200">
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-900">Total Bobot:</td>
                                <td class="px-4 py-4">
                                    <span class="font-bold text-lg {{ $teacherTotalWeight == 1.0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($teacherTotalWeight, 2) }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SAW Method Info -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-book"></i>
                Informasi Metode SAW
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Tipe Kriteria -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-200">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-tag text-indigo-600"></i>
                        Tipe Kriteria:
                    </h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900">Benefit (Keuntungan):</strong>
                                <p class="text-sm text-gray-600 mt-1">Semakin tinggi nilai semakin baik.</p>
                                <p class="text-xs text-gray-500 mt-1"><em>Contoh: Nilai Akademik, Kehadiran, Kinerja</em></p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-minus text-white"></i>
                            </div>
                            <div>
                                <strong class="text-gray-900">Cost (Biaya):</strong>
                                <p class="text-sm text-gray-600 mt-1">Semakin rendah nilai semakin baik.</p>
                                <p class="text-xs text-gray-500 mt-1"><em>Contoh: Ketidakhadiran, Pelanggaran, Keterlambatan</em></p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Bobot Kriteria -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-5 border border-blue-200">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-weight text-blue-600"></i>
                        Bobot Kriteria:
                    </h4>
                    <ul class="space-y-2.5">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                            <span class="text-gray-700">Bobot berkisar antara <strong class="text-blue-600">0.00 - 1.00</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                            <span class="text-gray-700"><strong class="text-blue-600">Total bobot harus = 1.0</strong> (atau 100%)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                            <span class="text-gray-700">Bobot menunjukkan tingkat kepentingan kriteria</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                            <span class="text-gray-700">Gunakan tombol <strong class="text-yellow-600">Normalisasi</strong> untuk menyeimbangkan bobot secara otomatis</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contoh Kriteria Siswa -->
            <div class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl p-5 border border-gray-200">
                <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-list-ul text-gray-600"></i>
                    Contoh Kriteria Siswa:
                </h4>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-300">
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase bg-gray-100">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase bg-gray-100">Nama Kriteria</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase bg-gray-100">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase bg-gray-100">Bobot</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase bg-gray-100">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-white transition-colors duration-150">
                                <td class="px-4 py-3 font-mono font-bold text-gray-900">C1</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">Nilai Akademik</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-plus-circle"></i>
                                        Benefit
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-bold text-gray-900">0.40</td>
                                <td class="px-4 py-3 text-sm text-gray-600">Rata-rata nilai ujian (40%)</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors duration-150">
                                <td class="px-4 py-3 font-mono font-bold text-gray-900">C2</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">Kehadiran</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-plus-circle"></i>
                                        Benefit
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-bold text-gray-900">0.30</td>
                                <td class="px-4 py-3 text-sm text-gray-600">Persentase kehadiran (30%)</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors duration-150">
                                <td class="px-4 py-3 font-mono font-bold text-gray-900">C3</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">Sikap</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-plus-circle"></i>
                                        Benefit
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-bold text-gray-900">0.20</td>
                                <td class="px-4 py-3 text-sm text-gray-600">Penilaian sikap (20%)</td>
                            </tr>
                            <tr class="hover:bg-white transition-colors duration-150">
                                <td class="px-4 py-3 font-mono font-bold text-gray-900">C4</td>
                                <td class="px-4 py-3 font-semibold text-gray-900">Pelanggaran</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold">
                                        <i class="fas fa-minus-circle"></i>
                                        Cost
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-bold text-gray-900">0.10</td>
                                <td class="px-4 py-3 text-sm text-gray-600">Jumlah pelanggaran (10%)</td>
                            </tr>
                        </tbody>
                        <tfoot class="border-t-2 border-gray-300">
                            <tr class="bg-gray-100">
                                <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-900">Total:</td>
                                <td class="px-4 py-3 font-bold text-lg text-green-600">1.00</td>
                                <td class="px-4 py-3 text-sm text-gray-600">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
