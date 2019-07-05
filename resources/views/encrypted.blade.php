@extends('template')

@section('title')
Encryption
@endsection
@section('head')
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection
@section('body')
<div class="flex-center position-ref full-height">
    @include('links')
    <div class="content">
        <div class="title m-b-md">
            Success!!
        </div>
        <div class="links">
            Key: {{ $key }}
        </div>
        <div class="links">
            <a href="{{ Storage::url($path) }}" class="button" id="file-upload">Download</a>
            {{-- <a href="{{ read_file(Storage::url($path)) }}" class="button" id="file-upload">Download</a> --}}
        </div>
    </div>
</div>
<script>
    document.getElementById("file-upload").onchange = function () {
        document.getElementById("form").submit();
    }
</script>
@endsection
