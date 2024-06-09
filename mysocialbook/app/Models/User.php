<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function userdata()
    {
        return $this->belongsTo("UserData", "userdata_id");
    }

    public function image()
    {
        return $this->belongsTo("Image", "profile_pic_id");
    }

    public function posts()
    {
        return $this->hasMany("Post", "user_id");
    }

    public function comments()
    {
        return $this->hasMany("Comment", "user_id");
    }

    public function likedPosts()
    {
        return $this->belongsToMany("Post", "likes", "user_id", "post_id")
                    ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany("User", "follows", "followed_user_id", "follower_id")
                    ->withTimestamps();
    }

    public function followedUsers()
    {
        return $this->belongsToMany("User", "follows", "follower_id", "followed_user_id")
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
