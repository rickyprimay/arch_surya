@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="font-bold text-2xl">User</h1>
        @if(isset($user))
        <p class="text-gray-400">Surya Arch / Edit User</p>
        @else
        <p class="text-gray-400">Surya Arch / Tambah User</p>
        @endif
    </div>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-6">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h2>

            <form action="{{ isset($user) ? route('dashboard.user.update', $user->id) : route('dashboard.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($user))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" id="username" value="{{ isset($user) ? $user->username : old('username') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('username') border-red-500 @enderror" required>
                        @error('username')
                            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" value="{{ isset($user) ? $user->name : old('name') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('name') border-red-500 @enderror" required>
                        @error('name')
                            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ isset($user) ? $user->email : old('email') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('password') border-red-500 @enderror" {{ isset($user) ? '' : 'required' }}>
                        @error('password')
                            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select name="role" id="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm @error('role') border-red-500 @enderror" required>
                            <option value="" selected disabled>Pilih Jabatan</option>
                            <option value="0" {{ isset($user) && $user->role == 0 ? 'selected' : '' }}>Wakil Dekan</option>
                            <option value="1" {{ isset($user) && $user->role == 1 ? 'selected' : '' }}>Kepala Urusan</option>
                            <option value="2" {{ isset($user) && $user->role == 2 ? 'selected' : '' }}>Prodi</option>
                            <option value="3" {{ isset($user) && $user->role == 3 ? 'selected' : '' }}>Kelompok Keahlian</option>
                            <option value="3" {{ isset($user) && $user->role == 4 ? 'selected' : '' }}>Staf</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>

                <div class="mt-6">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ isset($user) ? 'Update User' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
