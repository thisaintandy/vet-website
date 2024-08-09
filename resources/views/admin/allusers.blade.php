@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')

    <div class="pt-3" style="margin-top: 7.5%">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-cover bg-center" style="background-image: url('/images/petdoctor.jpg'); height: 100px">
                    <h4 class="text-white"></h4>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <form action="{{ route('admin.allusers') }}" method="GET" class="flex justify-center mb-6">
            <input type="text" name="name" class="border border-gray-300 p-2 rounded-l-md w-full md:w-1/4 h-12" value="{{ request('name') }}" placeholder="Name">
            <button type="submit" class="bg-gray-600 text-white px-4 rounded-r-md h-12">Search</button>
        </form>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Name</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Email Address</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Phone Number</th>
                        <th class="text-left py-3 px-4 font-semibold text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">{{ $user->phone_number }}</td>
                            <td class="py-3 px-4">
                                <form action="{{ route('delete.user', ['id' => $user->email]) }}" method="post" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('post')
                                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded">Delete </button>
                                </form>

                                <a href="{{ route('edit.user', ['id' => $user->id]) }}" class="bg-gray-600 text-white px-4 py-2 rounded">Edit + </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 px-4">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to remove this user?');
    }
</script>
