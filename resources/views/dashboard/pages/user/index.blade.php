@extends('dashboard.layouts.app')

@section('content')
<div class="">
  <a href="" class="bg-green-500 text-white py-2 px-4 rounded-lg mb-4 inline-flex items-center">
    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4v16m-8-8h16"></path></svg>
    Buat Event
</a>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 border border-black">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 table-border">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3">No. </th>
            <th scope="col" class="px-6 py-3">Username</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Nama</th>
            <th scope="col" class="px-6 py-3">Jabatan</th>
            <th scope="col" class="px-6 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr class="odd:bg-white even:bg-gray-50 border-b">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $user->username }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">
                    @if($user->role == 0)
                        Wakil Dekan
                    @elseif($user->role == 1)
                        Kepala Urusan
                    @elseif($user->role == 2)
                        Prodi
                    @elseif($user->role == 3)
                        Staf
                    @else
                        Lainnya
                    @endif
                </td>
                <td class="">
                    <button data-modal-target="edit-modal-" data-modal-toggle="edit-modal-" type="button" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Edit</button>
                    <button data-modal-target="delete-modal-" data-modal-toggle="delete-modal-" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
