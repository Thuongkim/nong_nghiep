<?php

namespace App\Observers;

use App\News;
use App\Comment;

class NewsObserver
{
    /**
     * Listen to the News created event.
     *
     * @param  News  $news
     * @return void
     */
    public function created(News $news)
    {
        News::clearCache();
        try {
            Comment::create([
                'notify'    => 0,
                'created_by'=> 1,
                'read'      => 1,
                'news_id'   => $news->id,
                'content'   => '[Tự động] Cám ơn bạn đã gửi bài viết cho ViCloud.',
                'source'    => Define\News::SOURCE_COMMENT_ADMIN
            ]);

            $user = \Auth::guard('admin')->user();
            \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->cc([['email' => env('MAIL_CC_ADDRESS'), 'name' => env('MAIL_CC_NAME')]])->later(Carbon::now()->addSeconds(5), new \App\Mail\NewPost($user, $news));
        } catch (Exception $e) {
            \Log::info('#Email: ' . $title . '<br/>Description: ' . $e->getMessage());
        }
    }

    /**
     * Listen to the News deleting event.
     *
     * @param  News  $news
     * @return void
     */
    public function updating(News $news)
    {
        if ($news->paid <> $news->getOriginal('paid')) {
            if ($news->paid) {
                Comment::create([
                    'notify'    => 0,
                    'created_by'=> 1,
                    'read'      => 1,
                    'news_id'   => $news->id,
                    'content'   => '[Tự động] ViCloud đã thanh toán chi phí cho bài viết của bạn.',
                    'source'    => Define\News::SOURCE_COMMENT_ADMIN
                ]);
            } else {
                Comment::create([
                    'notify'    => 0,
                    'created_by'=> 1,
                    'read'      => 1,
                    'news_id'   => $news->id,
                    'content'   => '[Tự động] ViCloud CHƯA thanh toán chi phí cho bài viết của bạn.',
                    'source'    => Define\News::SOURCE_COMMENT_ADMIN
                ]);
            }
        }

        if ($news->sendMail) {
            $changeAttributes = [];
            if ($news->title <> $news->getOriginal('title')) $changeAttributes['title'] = 'title';
            if ($news->summary <> $news->getOriginal('summary')) $changeAttributes['summary'] = 'summary';
            if ($news->content <> $news->getOriginal('content')) $changeAttributes['content'] = 'content';
            if ($news->image <> $news->getOriginal('image')) $changeAttributes['image'] = 'image';
            if ($news->category_id <> $news->getOriginal('category_id')) $changeAttributes['category_id'] = 'category_id';
            if ($news->status <> $news->getOriginal('status')) $changeAttributes['status'] = 'status';
            if ($news->featured <> $news->getOriginal('featured')) $changeAttributes['featured'] = 'featured';
            if ($news->closed <> $news->getOriginal('closed')) $changeAttributes['closed'] = 'closed';
            if ($news->paid <> $news->getOriginal('paid')) $changeAttributes['paid'] = 'paid';
            if (!count($changeAttributes)) {
                unset($news->sendMail);
                return;
            }
            try {
                $user = \Auth::guard('admin')->user();
                if ($news->created_by <> $user->id) {
                    $creator = User::find($news->created_by);
                    // var_dump(view('emails.update_post', ['news' => $news, 'user' => $user, 'changeAttributes' => $changeAttributes, 'original' =>  $news->original, 'creator' => $creator])->render());exit;
                    \Mail::to([['email' => $creator->email, 'name' => $creator->fullname]])->cc([['email' => env('MAIL_CC_ADDRESS'), 'name' => env('MAIL_CC_NAME')], ['email' => $user->email, 'name' => $user->fullname]])->later(Carbon::now()->addSeconds(5), new \App\Mail\UpdatePost($user, $changeAttributes, $news, $news->original, $creator));
                } else {
                    // var_dump(view('emails.update_post', ['news' => $news, 'user' => $user, 'changeAttributes' => $changeAttributes,  'original' => $news->original, 'creator' => null])->render());exit;
                    \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->cc([['email' => env('MAIL_CC_ADDRESS'), 'name' => env('MAIL_CC_NAME')]])->later(Carbon::now()->addSeconds(5), new \App\Mail\UpdatePost($user, $changeAttributes, $news, $news->original));
                }
            } catch (Exception $e) {
                \Log::info('#Email: ' . $title . '<br/>Description: ' . $e->getMessage());
            }
        }
        unset($news->sendMail);
    }

    public function updated(News $news)
    {
        News::clearCache();
    }


    public function saving(News $news)
    {
        if (!is_null($news->getOriginal('status')) && $news->status <> $news->getOriginal('status')) News::clearCache();
    }

    public function deleted(News $news)
    {
        News::clearCache();
        try {
            $news = News::withTrashed()->find($news->id);
            $user = \Auth::guard('admin')->user();
            if ($news->created_by <> $user->id) {
                $creator = User::find($news->created_by);
                \Mail::to([['email' => $creator->email, 'name' => $creator->fullname]])->cc([['email' => env('MAIL_CC_ADDRESS'), 'name' => env('MAIL_CC_NAME')], ['email' => $user->email, 'name' => $user->fullname]])->send(new \App\Mail\DeletePost($user, $news));
            } elseif ($news->status) {
                \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->cc([['email' => env('MAIL_CC_ADDRESS'), 'name' => env('MAIL_CC_NAME')]])->send(new \App\Mail\DeletePost($user, $news));
            }
        } catch (Exception $e) {
            \Log::info('#Email: ' . $title . '<br/>Description: ' . $e->getMessage());
            return;
        } finally {
            return;
        }

        return;
    }
}