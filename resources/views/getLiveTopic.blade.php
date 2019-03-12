@extends('layouts.app')

@section('content')
    <form action ="{{ action('TweetsController@live') }}", method = 'POST' style="width:100%">
        @csrf
        <div class="d-flex justify-content-center" style="border:black">
        <label>Topic</label>
        <input class="form-control" name="topic" id="myInput" type="text" placeholder="..." style="width:60%">        {{-- Search bar --}}
        <button class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection