<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemindReceiveHubLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:receive_hublink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remind receive hub link';

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
        $objToNotify= \App\ObjNotification::find(1);
        if (is_null($objToNotify)) exit;
        $roles      = $objToNotify->roles()->pluck('roles.id')->toArray();
        $userIds    = \DB::table('role_user')->whereIn('role_id', $roles)->pluck('user_id', 'user_id')->toArray();
        $userIds    = array_merge($userIds, $objToNotify->users()->pluck('users.id', 'users.id')->toArray());
        $users      = \App\User::where('activated', 1)->whereIn('id', $userIds)->get();
        $when       = \Carbon\Carbon::now()->addSeconds(5);
        $messsage   = "";
        foreach ($users as $user) {
            if (\App\Store::where('assigned_to', $user->id)->where("status", \App\Define\Store::STATUS_PROCESSING)->count()) continue;

            \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->later($when, new \App\Mail\RemindReceiveHubLinkEmail($user));

            $messsage .= (" " . $user->fullname . " (Lần cuối đăng nhập: " . ($user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : "-Chưa đăng nhập lần nào-") . ");");
            $user = null;
        }

        $messsage = "Đã gửi mail thông báo nhận bài dịch tới: " . ($messsage ? $messsage : " KHÔNG CÓ AI CHƯA NHẬN!");
        $user = \App\User::find(1);//administrator
        $user->notify((new \App\Notifications\RemindReceiveHubLinkNotify($messsage))->delay($when));
        exit;
    }
}
