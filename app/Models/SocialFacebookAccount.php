<?php
namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class SocialFacebookAccount extends Model
{
    protected $table = 'social_facebook_accounts';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'provider_user_id', 'provider', 'created'
    ];
    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}