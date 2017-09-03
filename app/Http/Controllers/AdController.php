<?php namespace App\Http\Controllers;

use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Ads;
use App\User;
use App\Http\Requests\AdFormRequest;

class AdController extends Controller {

  /**
   * The number of ads per page.
   *
   * @var int
   */
  private $chunk = 5;

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return view('home')->withAds(
      Ads::where('active', 1)
         ->orderBy('created_at', 'desc')
         ->paginate($this->chunk)
    )->withTitle('Latest Ads');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @param  Request  $request
   * @return Response
   */
  public function create(Request $request)
  {
    if ($request->user()->canPost()) {
      $data['ad'] = new Ads();
      $data['action'] = '/new-ad';
      $data['title'] = 'Create Ad';

      return view('ads.form', $data);
    } else {
      return redirect('/')->withErrors('You have not sufficient permissions for writing ad');
    }
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  AdFormRequest  $request
  * @return Response
  */
  public function store(AdFormRequest $request)
  {
    $ad = new Ads();
    $ad->title = $request->get('title');
    $ad->description = $request->get('description');
    $ad->slug = str_slug($ad->title);
    $ad->author_id = $request->user()->id;

    if ($request->has('save')) {
      $ad->active = 0;
      $message = 'Ad saved successfully';            
    } else {
      $ad->active = 1;
      $message = 'Ad published successfully';
    }

    $ad->save();

    return redirect('edit/'.$ad->slug)->withMessage($message);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $slug
   * @return Response
   */
  public function show($slug)
  {
    $ad = Ads::where('slug', $slug)->first();

    if (!$ad) {
      return redirect('/')->withErrors('requested page not found');
    } else {
      return view('ads.show')->withAd($ad);
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
  * @param  Request  $request
   * @param  int  $slug
   * @return Response
   */
  public function edit(Request $request, $slug)
  {
    $ad = Ads::where('slug', $slug)->first();

    if ($ad && ($request->user()->id == $ad->author_id || $request->user()->isAdmin())) {
      $data['title'] = 'Edit Ad';
      $data['action'] = url('/update');

      return view('ads.form', $data)->with('ad', $ad);
    } else {
      return redirect('/')->withErrors('you have not sufficient permissions');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  AdFormRequest  $request
   * @return Response
   */
  public function update(AdFormRequest $request)
  {
    $ad = Ads::find($request->input('ad_id'));

    if ($ad && ($ad->author_id == $request->user()->id || $request->user()->isAdmin())) {
      $ad->title = $request->input('title');
      $ad->slug = str_slug($ad->title);
      $ad->description = $request->input('description');

      if ($request->has('save')) {
        $ad->active = 0;
        $message = 'Ad saved successfully';
        $landing = 'edit/'.$ad->slug;
      } else {
        $ad->active = 1;
        $message = 'Ad updated successfully';
        $landing = $ad->slug;
      }

      $ad->save();

      return redirect($landing)->withMessage($message);
    } else {
      return redirect('/')->withErrors('you have not sufficient permissions');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $ad = Ads::find($id);
    $request_user = $request->user();

    if ($ad && ($ad->author_id == $request_user->id || $request_user->isAdmin())) {
      $ad->delete();
      $data['message'] = 'Ad deleted Successfully';
    } else {
      $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
    }

    return redirect('/')->with($data);
  }

}
