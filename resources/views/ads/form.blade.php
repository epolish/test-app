@extends('app')

@section('title')
{{ $title }}
@endsection

@section('content')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/tinymce.app.js') }}"></script>
<form method="post" action='{{ $action }}'>
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="ad_id" value="{{ $ad->id or old('ad_id') }}">
  <div class="form-group">
    <input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if (!old('title')){{ $ad->title }}@endif{{ old('title') }}"/>
  </div>
  <div class="form-group">
    <textarea name='description'class="form-control">
      @if (!old('description'))
      {!! $ad->description !!}
      @endif
      {!! old('description') !!}
    </textarea>
  </div>
  @if ($ad->active == '1')
  <input type="submit" name='publish' class="btn btn-success" value="Save"/>
  @else
  <input type="submit" name='publish' class="btn btn-success" value="Publish"/>
  @endif
  <input type="submit" name='save' class="btn btn-default" value="Save As Draft" />
  <a href="{{  url('delete/'.$ad->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
</form>
@endsection