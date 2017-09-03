@extends('app')

@section('title')
  @if ($ad)
    {{ $ad->title }}
    @if (!Auth::guest() && ($ad->author_id == Auth::user()->id || Auth::user()->isAdmin()))
      <button class="btn" style="float: right">
        <a href="{{ url('edit/'.$ad->slug) }}">Edit Ad</a>
      </button>
    @endif
  @else
    Page does not exist
  @endif
@endsection

@section('title-meta')
<p>
  {{ $ad->created_at->format('M d,Y \a\t h:i a') }} By
  <a href="{{ url('/user/'.$ad->author_id) }}">{{ $ad->author->name }}</a>
</p>
@endsection

@section('content')
@if ($ad)
<div class="description">
  {!! $ad->description !!}
</div>
@else
404 error
@endif
@endsection