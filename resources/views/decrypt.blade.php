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
            Decryption
        </div>
        <form id="form" action="{{ route('decrypt') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="links">
                Key: <input name="key" type="password" />
            </div>
            <br>
            <div class="links">
                <label for="file-upload" class="button">
                    Pilih File
                </label>
                <input id="file-upload" name="file" type="file" />
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("file-upload").onchange = function () {
        document.getElementById("form").submit();
    }
</script>
@endsection
