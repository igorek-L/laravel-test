<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    const POST_KEY_CONFIG = 'post';

    const POST_STATUS_DRAFT = 'POST_STATUS_DRAFT';
    const POST_STATUS_READY_FOR_REWIEW = 'POST_STATUS_READY_FOR_REVIEW';
    const POST_STATUS_PUBLISHED = 'POST_STATUS_PUBLISHED';
    const POST_STATUS_DECLINED = 'POST_STATUS_DECLINED';
    const POST_STATUS_REMOVED = 'POST_STATUS_REMOVED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'post_status', 'image', 'user_id'
    ];

    /**
     * The post that belong to the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Comments','user_id', 'id');
    }
}
