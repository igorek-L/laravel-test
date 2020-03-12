<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    const COMMENT_STATUS_READY_FOR_REVIEW = 'COMMENT_STATUS_READY_FOR_REVIEW';
    const COMMENT_STATUS_PUBLISHED = 'COMMENT_STATUS_PUBLISHED';
    const COMMENT_STATUS_REMOVED = 'COMMENT_STATUS_PUBLISHED';

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
}
