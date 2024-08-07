@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')



    <div class="py-12">
        <form action="{{ route('admin.allusers') }}" method="GET" class="class="border-gray-300 ml-11" style="margin-left: 20%;"">
            <div>
                <div>
                    <!-- Pet Name Input -->
                    <input type="text" name="name" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/3 h-12" value="{{ request('name') }}" placeholder="Search Name">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 md:mt-0 h-12">Search</button>
            </div>
        </form>

        <table class="border-gray-300 ml-11" style="margin-left: 20%;">
            <thead>
                <tr>
                    <th class="border-b px-2 py-2 text-left">Name</th>
                    <th class="border-b px-2 py-2 text-left">Email Address</th>
                    <th class="border-b px-2 py-2 text-left">Phone Number</th>
                    <th class="border-b px-2 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="border-b px-2 py-2">{{ $user->name }}</td>
                        <td class="border-b px-2 py-2">{{ $user->email }}</td>
                        <td class="border-b px-2 py-2">{{ $user->phone_number }}</td>

                        <td>
                            <div class="mt-auto flex flex-col space-y-2">
                            <a href="">Remove</a>
                            </div>
                        <td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border-b px-2 py-2 text-center">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
