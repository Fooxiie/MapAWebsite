@extends('mainLayout')

@section('title', '')

@section('content')
    <div class="bg-gray-700 p-3 mb-3">
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

    <div id="myDiagramDiv" class="mx-auto my-auto h-auto">
        <svg id="schema" width="800" height="600" class="bg-gray-700 mx-auto my-auto h-auto "
             style="user-select: none">
        </svg>
    </div>

    <script>

        targets = {
            "s.yimg.com": [],
            "de.yahoo.com": [{"hostname": "de.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "au.yahoo.com": [{"hostname": "au.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "ca.yahoo.com": [{"hostname": "ca.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "uk.yahoo.com": [{"hostname": "uk.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "sg.yahoo.com": [{"hostname": "sg.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "www.yahoo.com": [{"hostname": "www.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "espanol.yahoo.com": [{"hostname": "espanol.yahoo.com"}, {"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "edge-mcdn.secure.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "br.yahoo.com": [{"hostname": "s.yimg.com"}],
            "hk.yahoo.com": [{"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "in.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "es.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "fr-be.yahoo.com"}, {"hostname": "it.yahoo.com"}, {"hostname": "be.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "hk.search.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "tw.yahoo.com": [{"hostname": "s.yimg.com"}, {"hostname": "de.yahoo.com"}, {"hostname": "au.yahoo.com"}, {"hostname": "ca.yahoo.com"}, {"hostname": "uk.yahoo.com"}, {"hostname": "in.yahoo.com"}, {"hostname": "sg.yahoo.com"}, {"hostname": "www.yahoo.com"}, {"hostname": "es.yahoo.com"}, {"hostname": "espanol.yahoo.com"}, {"hostname": "fr-be.yahoo.com"}, {"hostname": "it.yahoo.com"}, {"hostname": "be.yahoo.com"}, {"hostname": "br.yahoo.com"}, {"hostname": "hk.yahoo.com"}, {"hostname": "tw.yahoo.com"}, {"hostname": "tw.search.yahoo.com"}, {"hostname": "sb.scorecardresearch.com"}],
            "edge-mcdn.secure.yahoo.com": [],
            "sb.scorecardresearch.com": []
        };
        source = "fr.yahoo.com";

        {{--targets = {!! json_encode($scan) !!};--}}
        {{--source = "{!! $fromUrl !!}";--}}
    </script>
@endsection
