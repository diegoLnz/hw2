<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'userdata_id',
        'profile_pic_id'
    ];

    public function userdata()
    {
        return $this->belongsTo(UserData::class, "userdata_id");
    }

    public function image()
    {
        return $this->belongsTo(Image::class, "profile_pic_id");
    }

    public function posts()
    {
        return $this->hasMany(Post::class, "user_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "user_id");
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, "likes", "user_id", "post_id")
                    ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, "follows", "followed_user_id", "follower_id")
                    ->withTimestamps();
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, "follows", "follower_id", "followed_user_id")
                    ->withTimestamps();
    }

    #region Follow methods

    public function follow(User $user)
    {
        return $this->followings()->attach($user);
    }

    public function unfollow(User $user)
    {
        return $this->followings()->detach($user);
    }

    public function isFollowing(User $user)
    {
        return $this->followings()->where('followed_id', $user->id)->exists();
    }

    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    #endregion

    #region Like methods

    public function likePost(Post $post)
    {
        return $this->likedPosts()->attach($post);
    }

    public function unlikePost(Post $post)
    {
        return $this->likedPosts()->detach($post);
    }

    public function hasLikedPost(Post $post)
    {
        return $this->likedPosts()->where('post_id', $post->id)->exists();
    }

    #endregion
}
