<?php

namespace App\Observers;

use App\Comment;

class CommentObserver
{
    /**
     * Listen to the Comment created event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        //
    }

    /**
     * Listen to the Comment deleting event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function deleting(Comment $comment)
    {
        //
    }
}