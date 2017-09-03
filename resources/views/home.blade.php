@extends('app')

@section('title')
{{ $title }}
@endsection

@section('content')
@if (!$ads->count())
There is no ad till now. Login and write a new ad now.
@else
<div class="row">
	<div class="col-xs-12">
	 	@foreach ($ads as $ad)
	  <div class="list-group">
	    <div class="list-group-item">
	      <h3><a href="{{ url('/'.$ad->slug) }}">{{ $ad->title }}</a>
	        @if (!Auth::guest() && ($ad->author_id == Auth::user()->id || Auth::user()->isAdmin()))
	          @if ($ad->active == '1')
	          <button class="btn" style="float: right"><a href="{{ url('edit/'.$ad->slug) }}">Edit Ad</a></button>
	          @else
	          <button class="btn" style="float: right"><a href="{{ url('edit/'.$ad->slug) }}">Edit Draft</a></button>
	          @endif
	        @endif
	      </h3>
	      <p>{{ $ad->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$ad->author_id) }}">{{ $ad->author->name }}</a></p>
	    </div>
	    <div class="list-group-item">
	      <article>
	        {!! str_limit($ad->description, $limit = 1500, $end = '....... <a href='.url("/".$ad->slug).'>Read More</a>') !!}
	      </article>
	    </div>
	  </div>
	  @endforeach
	  {!! $ads->render() !!}
	</div>
</div>
@endif
@endsection
