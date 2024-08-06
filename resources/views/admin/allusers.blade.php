@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <table class="min-w-full border-gray-300 ml-11">
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
