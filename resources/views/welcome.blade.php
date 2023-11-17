@extends('mainLayout')

@section('title', 'Home')

@section('content')
    <div class="bg-gray-700 p-3">
        <form class="align-items-center flex w-full justify-center"
              action="{{route('launchscan')}}" method="post">
            @csrf
            <input type="url" class="shadow-lg rounded bg-gray-800
            border-none w-full" placeholder="https://..." name="urlToScan"
                   id="urlToScan"/>
            <button class="btn bg-amber-400 hover:bg-amber-200 hover:text-gray-950
            h-max
            flex-shrink-0">Map me !
            </button>
        </form>
    </div>

@endsection
