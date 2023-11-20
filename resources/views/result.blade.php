@extends('mainLayout')

@section('title', 'Results')

@section('content')

    <div class="text-center mt-3 p-3 bg-gray-700">
        <h2>Result for <span class="text-amber-500">{{$fromUrl}}</span></h2>
    </div>

    <div id="result">
        @foreach($scan as $key => $value)

            <div>{{$key}}</div>
            @if($value != [])
                <div>content : {{count($value)}}</div>
                @foreach($value as $subvalue)
                    <div>{{$subvalue}}</div>
                @endforeach
            @endif

        @endforeach
    </div>
@endsection
