@extends('layouts.full')
@section('title', __('Ranking'))

@section('content')
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                Guild Name: {{ $guilds->Name }}

            </div>
        </div>
    </div>
@endsection
