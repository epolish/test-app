<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'email', 'password'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];
 
  /**
   * Returns user's ads.
   *
   * @return object
   */
  public function ads()
  {
    return $this->hasMany('App\Ads','author_id');
  }

  /**
   * Checks, if user can post an ad.
   *
   * @return boolean
   */
  public function canPost()
  {
    $role = $this->role;
    return ($role == 'author' || $role == 'admin') ? true : false;
  }

  /**
   * Checks, if user is an admin.
   *
   * @return boolean
   */
  public function isAdmin()
  {
    return ($this->role == 'admin') ? true : false;
  }

}
