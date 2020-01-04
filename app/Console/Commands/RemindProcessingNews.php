<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User as User;
use App\Store as Store;
use Carbon\Carbon;

class RemindProcessingNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:processing_news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $stores = Store::whereRaw("status = '" . \App\Define\Store::STATUS_PROCESSING . "' AND (date(assigned_at) < curdate()-2)")->pluck('name', 'assigned_to')->toArray();
        $when = Carbon::now()->addSeconds(5);

        $messsage = "";
        foreach ($stores as $assignedTo => $name) {
            $user = User::find($assignedTo);
            if (!$user->activated) continue;
            \Mail::to([['email' => $user->email, 'name' => $user->fullname]])->later($when, new \App\Mail\RemindProcessingNewsEmail($user, $name));
            $messsage .= (" " . $user->fullname . " (Bài dịch: {$name} - Lần cuối đăng nhập: " . ($user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : "-Chưa đăng nhập lần nào-") . ");");
            $user = null;
        }
        $messsage = "Đã gửi mail nhắc nhở xử lý bài viết đã đăng ký cho: " . ($messsage ? $messsage : " KHÔNG CÓ AI!");
        $user = User::find(1);//administrator
        $user->notify((new \App\Notifications\RemindProcessingNewsNotify($messsage))->delay($when));
        exit;
    }
}
