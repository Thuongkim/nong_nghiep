<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User as User;
use Carbon\Carbon;

class RemindAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify to user long time no access!';

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
        $users = User::whereRaw("activated = 1 AND (last_login IS NULL OR date(last_login) < curdate()-3)")->get();
        $when = Carbon::now()->addSeconds(5);
        $messsage = "";
        foreach ($users as $user) {
            \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->later($when, new \App\Mail\RemindAccessEmail($user));
            $messsage .= (" " . $user->fullname . " (Lần cuối đăng nhập: " . ($user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : "-Chưa đăng nhập lần nào-") . ");");
            $user = null;
        }
        $messsage = "Đã gửi mail nhắc nhở đăng nhập hệ thống cho: " . ($messsage ? $messsage : " CHÚC MỪNG, mọi thành viên đều đăng nhập gần đây 1 ngày!");
        $user = User::find(1);//administrator
        $user->notify((new \App\Notifications\RemindAccessNotify($messsage))->delay($when));
        exit;
    }
}
