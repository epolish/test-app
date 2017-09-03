<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Ads;
use App\User;

class UserController extends Controller {

  /**
   * The number of ads per page.
   *
   * @var int
   */
  private $chunk = 5;

  /**
   * Display active ads of a particular user.
   * 
   * @param  int  $id
   * @return view
   */
  public function userAds($id)
  {
    $title = User::find($id)->name;
    $ads = Ads::where('author_id', $id)
              ->where('active', 1)
              ->orderBy('updated_at','desc')
              ->paginate($this->chunk);

    return view('home')->withAds($ads)->withTitle($title);
  }

  /**
   * Display all of the ads of a particular user.
   * 
   * @param  Request  $request
   * @return view
   */
  public function userAdsAll(Request $request)
  {
    $user = $request->user();
    $title = $user->name;
    $ads = Ads::where('author_id', $user->id)
              ->orderBy('updated_at', 'desc')
              ->paginate($this->chunk);

    return view('home')->withAds($ads)->withTitle($title);
  }

  /**
   * Display draft ads of a currently active user.
   * 
   * @param  Request  $request
   * @return view
   */
  public function userAdsDraft(Request $request)
  {
    $user = $request->user();
    $title = $user->name;
    $ads = Ads::where('author_id', $user->id)
              ->where('active', 0)
              ->orderBy('updated_at', 'desc')
              ->paginate($this->chunk);

    return view('home')->withAds($ads)->withTitle($title);
  }

  /**
   * Display user's profile.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return view
   */
  public function profile(Request $request, $id) 
  {
    $data['user'] = User::find($id);
    if (!$data['user']) {
      return redirect('/');
    }

    $request_user = $request->user();
    if ($request_user && $data['user']->id == $request_user->id) {
      $data['author'] = true;
    } else {
      $data['author'] = null;
    }

    $active_ads = $data['user']->ads->where('active', 1);
    $data['ads_count'] = $data['user']->ads->count();
    $data['ads_active_count'] = $active_ads->count();
    $data['ads_draft_count'] = $data['ads_count'] - $data['ads_active_count'];
    $data['latest_ads'] = $active_ads->take(5);

    return view('admin.profile', $data);
  }

}
