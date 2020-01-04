<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CollaboratorNewsReportMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report_monthly:collaborator_news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bao cao luong tin tuc cua ctv hang thang.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $objToNotify= \App\ObjNotification::find(2);
        if (is_null($objToNotify)) exit;
        $roles      = $objToNotify->roles()->pluck('roles.id')->toArray();
        $userIds    = \DB::table('role_user')->whereIn('role_id', $roles)->pluck('user_id', 'user_id')->toArray();
        $userIds    = array_merge($userIds, $objToNotify->users()->pluck('users.id', 'users.id')->toArray());
        $users      = \App\User::where('activated', 1)->whereIn('id', $userIds)->get();

        $when       = \Carbon\Carbon::now()->addSeconds(5);
        $messsage   = "";
        $month      = date("m/Y", strtotime("-1 month"));
        $title      = "Thông báo kết quả bài viết tháng {$month} của bạn!";

        foreach ($users as $user) {
            // lay cac bai tu 01->cuoi thang truoc
            $news = \App\News::where('created_by', $user->id)->whereRaw('month(approved_at) = month(curdate())-1')->select("approved_at", "title", "id")->orderBy("approved_at")->get();
            \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->later($when, new \App\Mail\CollaboratorNewsReportMonthlyMail($user, $news, $title, $month));
            $messsage .= ($user->fullname . ": " . count($news) . ' bài x ' . \App\Helper\HString::currencyFormat($user->fee) . ' đ/bài = ' . \App\Helper\HString::currencyFormat(count($news) * $user->fee) . ' đ + Nợ cộng dồn tháng trước: ' . \App\Helper\HString::currencyFormat($user->debt) . ' đ =========');
            $user = null;
        }
        // dd($messsage);
        $user = \App\User::find(1);
        $user->notify((new \App\Notifications\RemindAccessNotify($title . '=>>>' . $messsage))->delay($when));
        exit;
    }
}
