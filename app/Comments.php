<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    const COMMENT_STATUS_READY_FOR_REVIEW = 'READY_FOR_REVIEW';
    const COMMENT_STATUS_PUBLISHED = 'PUBLISHED';
    const COMMENT_STATUS_REMOVED = 'REMOVED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'comment_status', 'user_id'
    ];

    /**
     * The comment that belong to the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Post');
    }
}
