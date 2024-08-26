@extends('dashboard.layouts.app')

@section('content')

    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="font-bold text-2xl">Dokumen</h1>
            <p class="text-gray-400">Surya Arch / Sumber Daya / Dokumen</p>
        </div>
        <div class="flex justify-end space-x-4 mb-4">
            <form id="filterForm" action="{{ route('dashboard.document') }}" method="GET" class="flex space-x-4">
                <div>
                    <label for="search" class="block mb-2 text-sm font-medium text-gray-900">Cari</label>
                    <input type="text" id="search" name="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                        placeholder="Cari dokumen berdasarkan nama dokumen" value="{{ request('search') }}">
                </div>
                
                <div>
                    <label for="division_id" class="block mb-2 text-sm font-medium text-gray-900">Urusan</label>
                    <select id="division_id" name="division_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                        <option value="">Pilih Urusan</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Filter</button>
                </div>
            </form>
        </div>

        @if(Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 4)
        <!-- Add Document Button -->
        <button data-modal-target="create-modal" data-modal-toggle="create-modal"
            class="flex items-center text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
            type="button">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4v16m-8-8h16"></path>
            </svg>
            Tambah Dokumen
        </button>
        @endif

        <!-- Documents Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 border border-black">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 table-border">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Urusan</th>
                        <th scope="col" class="px-6 py-3">File</th>
                        @if(Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 4)
                        <th scope="col" class="px-6 py-3">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $index => $document)
                        <tr class="odd:bg-white even:bg-gray-50 border-b">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $document->title }}</td>
                            <td class="px-6 py-4">{{ optional($document->division)->name }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $document->file) }}" class="text-blue-500 hover:underline"
                                    target="_blank">View File</a>
                            </td>
                            @if(Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 4)
                            <td class="px-6 py-4">
                                <button data-modal-target="edit-modal-{{ $document->id }}"
                                    data-modal-toggle="edit-modal-{{ $document->id }}"
                                    class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Edit</button>
                                <button type="button"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                    data-modal-toggle="popup-modal" data-document-id="{{ $document->id }}">Delete</button>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada dokumen</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal for Adding Document -->
        <div id="create-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah dokumen baru</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="create-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('dashboard.document.store') }}" method="POST" enctype="multipart/form-data"
                        class="p-4 md:p-5">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                    Dokumen</label>
                                <input type="text" name="title" id="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="Nama Dokument" required>
                            </div>
                            <div class="col-span-2">
                                <label for="division_id" class="block mb-2 text-sm font-medium text-gray-900">Urusan</label>
                                <select id="division_id" name="division_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    required>
                                    <option value="">Pilih Urusan</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="file" class="block mb-2 text-sm font-medium text-gray-900">File</label>
                                <input type="file" name="file" id="file"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    required>
                            </div>
                        </div>
                        <div class="flex gap-4 items-center">
                            <button type="submit"
                                class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah
                                Dokumen</button>
                            <button type="button"
                                class="text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm px-5 py-2.5 text-center"
                                data-modal-toggle="create-modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="popup-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 right-0 left-0 z-50 w-full h-full p-4 overflow-x-hidden overflow-y-auto hidden">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">Hapus Dokumen</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed text-gray-500">Apakah Anda yakin ingin menghapus dokumen ini?
                        </p>
                    </div>
                    <form id="deleteForm" action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex gap-4 items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="submit"
                                class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Hapus</button>
                            <button type="button"
                                class="text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm px-5 py-2.5 text-center"
                                data-modal-toggle="popup-modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modals for Editing Documents (Add Edit Form similarly to Create Form) -->
        @foreach ($documents as $document)
        <div id="edit-modal-{{ $document->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Dokumen</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="edit-modal-{{ $document->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('dashboard.document.update', $document->id) }}" method="POST" enctype="multipart/form-data"
                        class="p-4 md:p-5">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                    Dokumen</label>
                                <input type="text" name="title" id="title" value="{{ $document->title }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    placeholder="Nama Dokument" required>
                            </div>
                            <div class="col-span-2">
                                <label for="division_id" class="block mb-2 text-sm font-medium text-gray-900">Urusan</label>
                                <select id="division_id" name="division_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                    required>
                                    <option value="">Pilih Urusan</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}" {{ $document->division_id == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="file" class="block mb-2 text-sm font-medium text-gray-900">File</label>
                                <input type="file" name="file" id="file"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                        </div>
                        <div class="flex gap-4 items-center">
                            <button type="submit"
                                class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                            <button type="button"
                                class="text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm px-5 py-2.5 text-center"
                                data-modal-toggle="edit-modal-{{ $document->id }}">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <script>
        document.querySelectorAll('[data-modal-toggle="popup-modal"]').forEach(button => {
            button.addEventListener('click', () => {
                const documentId = button.getAttribute('data-document-id');
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/dashboard/documents/${documentId}`;
                document.getElementById('popup-modal').classList.remove('hidden');
            });
        });
        
        // JavaScript to handle closing modals
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-toggle');
                document.getElementById(modalId).classList.add('hidden');
            });
        });
    </script>

@endsection
