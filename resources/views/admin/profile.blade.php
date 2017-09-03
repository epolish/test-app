@extends('app')

@section('title')
{{ $user->name }}
@endsection

@section('content')
<style>.table-padding td{padding:3px 8px;}</style>
<div>
  <ul class="list-group">
    <li class="list-group-item">
      Joined on {{ $user->created_at->format('M d,Y \a\t h:i a') }}
    </li>
    <li class="list-group-item panel-body">
      <table class="table-padding">
        <tr>
          <td>Total Ads</td>
          <td>{{ $ads_count }}</td>
          @if ($author && $ads_count)
          <td><a href="{{ url('/my-all-ads') }}">Show All</a></td>
          @endif
        </tr>
        <tr>
          <td>Published Ads</td>
          <td>{{ $ads_active_count }}</td>
          @if ($ads_active_count)
          <td><a href="{{ url('/user/'.$user->id.'/ads') }}">Show All</a></td>
          @endif
        </tr>
        <tr>
          <td>Ads in Draft </td>
          <td>{{ $ads_draft_count }}</td>
          @if ($author && $ads_draft_count)
          <td><a href="{{ url('my-drafts') }}">Show All</a></td>
          @endif
        </tr>
      </table>
    </li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><h3>Latest Ads</h3></div>
  <div class="panel-body">
    @if (!empty($latest_ads[0]))
    @foreach ($latest_ads as $latest_ad)
      <p>
        <strong><a href="{{ url('/'.$latest_ad->slug) }}">{{ $latest_ad->title }}</a></strong>
        <span class="well-sm">On {{ $latest_ad->created_at->format('M d,Y \a\t h:i a') }}</span>
      </p>
    @endforeach
    @else
    <p>You have not written any ad till now.</p>
    @endif
  </div>
</div>
@endsection