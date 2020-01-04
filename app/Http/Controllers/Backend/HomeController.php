<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\News as News;
use \App\StaticPage as StaticPage;

use Carbon\Carbon;

class HomeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request)
    {
        // $news = News::get();
        // foreach ($news as $item) {
        //     $item->content = str_replace("http://sandbox.bctech.vn/", "http://vieclamnongnghiep.vn/", $item->content);
        //     $item->save();
        // }
        $myPostedToday =  News::where('created_by', $request->user()->id)->whereRaw('date(created_at) = curdate()')->count();
        $myPublishedToday =  News::where('created_by', $request->user()->id)->where('status', 1)->whereRaw('date(updated_at) = curdate()')->count();
        $myPostedThisMonth =  News::where('created_by', $request->user()->id)->whereRaw('month(created_at) = month(curdate())')->count();
        $myPublishedThisMonth =  News::where('created_by', $request->user()->id)->where('status', 1)->whereRaw('month(updated_at) = month(curdate())')->count();


        $myPostedYesterday =  News::where('created_by', $request->user()->id)->whereRaw('date(created_at) = curdate()-1')->count();
        $myPublishedYesterday =  News::where('created_by', $request->user()->id)->where('status', 1)->whereRaw('date(updated_at) = curdate()-1')->count();
        $myPostedLastMonth =  News::where('created_by', $request->user()->id)->whereRaw('month(created_at) = month(curdate())-1')->count();
        $myPublishedLastMonth =  News::where('created_by', $request->user()->id)->where('status', 1)->whereRaw('month(updated_at) = month(curdate())-1')->count();

        $newsStatistic = [];
        $createdNews = News::where('created_by', $request->user()->id)->where('created_at', '>=', date("Y-m-01 00:00:00"))
            ->select(\DB::raw("DAYOFMONTH(created_at) as day, count(id) as num "))->groupBy("day")->get()->toArray();
        $createdNews = array_column($createdNews, 'num', 'day');

        $publishedNews = News::where('created_by', $request->user()->id)->where('status', 1)->where('updated_at', '>=', date("Y-m-01 00:00:00"))
            ->select(\DB::raw("DAYOFMONTH(updated_at) as day, count(id) as num "))->groupBy("day")->get()->toArray();
        $publishedNews = array_column($publishedNews, 'num', 'day');

        $newsStatistic = [];
        for($i=1; $i<=date('d'); $i++) {
            // /'Ngày ' . $i . '/' . date('m')
            array_push($newsStatistic, [ 'y' => str_pad($i, 2, '0', STR_PAD_LEFT), 'created' => isset($createdNews[$i])? $createdNews[$i] : 0,
                'published' => isset($publishedNews[$i])? $publishedNews[$i] : 0 ]);
        }

        $newsStatistic = json_encode($newsStatistic);


        if ($request->user()->ability(['system', 'admin'], [])) {
            $countNews              = News::count();
            $countPublishedNews     = News::where('status', 1)->count();
            $countThisMonthNews              = News::whereRaw('month(created_at) = month(curdate())-1')->count();
            $countThisMonthPublishedNews     = News::where('status', 1)->whereRaw('month(created_at) = month(curdate())-1')->count();

            $countNewsByUser                = News::groupBy("created_by")->selectRaw("created_by, count(id) as counter")->get()->keyBy("created_by")->toArray();
            $countPublishedNewsByUser       = News::where('status', 1)->groupBy("created_by")->selectRaw("created_by, count(id) as counter")->get()->keyBy("created_by")->toArray();

            return view('backend.pages.home', compact('myPostedToday', 'myPublishedToday', 'myPostedThisMonth', 'myPublishedThisMonth', 'myPostedYesterday', 'myPublishedYesterday', 'myPostedLastMonth', 'myPublishedLastMonth', 'newsStatistic', 'countNews', 'countPublishedNews', 'countThisMonthNews', 'countThisMonthPublishedNews', 'countPublishedNewsByUser', 'countNewsByUser'));
        }


        return view('backend.pages.home', compact('myPostedToday', 'myPublishedToday', 'myPostedThisMonth', 'myPublishedThisMonth', 'myPostedYesterday', 'myPublishedYesterday', 'myPostedLastMonth', 'myPublishedLastMonth', 'newsStatistic'));
    }

    public function getLogin()
    {
        if(\Auth::guard('admin')->check()) return redirect()->route('admin.home');
        return view('backend.pages.login');
    }

    public function postLogin(Request $request)
    {
        $request->merge(['remember' => $request->input('remember', 0)]);
        $rules = [
            'email'     => 'required|email|min:10|max:50',
            'password'  => 'required|min:6|max:25',
        ];

        $this->validate($data = $request, $rules);
        $errors = new \Illuminate\Support\MessageBag;
        try {
            if (\Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'activated' => 1], $data['remember'])) {
                \Auth::guard('admin')->user()->last_login = date('Y-m-d H:i:s');
                \Auth::guard('admin')->user()->save();
                if (Session::get('loginRedirect_admin', '') == '') {
                    return redirect()->route('admin.home');
                }
                return redirect()->intended(Session::get('loginRedirect_admin', route('admin.home')));
            }
            $errors->add('invalid', "Invalid email/password.");
        } catch (\Exception $e) {
            $errors->add('error', $e->getMessage());
        }
        return back()->withErrors($errors)->withInput();
    }

    public function getLogout()
    {
        if(\Auth::guard('admin')->check())
            \Auth::guard('admin')->logout();
        return redirect()->route('admin.home');
    }

    public function get403()
    {
        return view('backend.pages.403');
    }

    public function get404()
    {
        return view('backend.pages.404');
    }

    public function changePassword()
    {
        return view('backend.pages.change_password');
    }

    public function account()
    {
        $user = \Auth::guard('admin')->user();
        return view('backend.pages.account', compact('user'));
    }

    public function postChangePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), array(
            'current_password'  => 'required|min:6|max:25',
            'new_password'      => 'required|min:6|max:25',
            're_password'       => 'same:new_password'
            ));

        $validator->setAttributeNames(trans('users'));
        if($validator->fails()) return back()->withErrors($validator)->withInput();

        $user = \Auth::guard('admin')->user();
        if ( !\Hash::check($request->input('current_password'), $user->password)) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('editError', 'Mật khẩu hiện tại không đúng');
            return back()->withErrors($errors);
        }
        $user->password = \Hash::make($request->new_password);
        $user->save();

        \Session::flash('message', trans('system.success'));
        \Session::flash('alert-class', 'success');

        return redirect()->route('admin.home');
    }

    public function postAccount(Request $request)
    {
        $request->merge(['menu_is_collapse' => $request->input('menu_is_collapse', 0)]);
        $validator = \Validator::make($request->all(), array(
            'fullname'          => 'required|min:6|max:30',
            'menu_is_collapse'  => 'required|in:0,1',
            ));

        $validator->setAttributeNames(trans('users'));
        if($validator->fails()) return back()->withErrors($validator)->withInput();

        $user = \Auth::guard('admin')->user();
        $user->fullname         = $request->input('fullname');
        $user->menu_is_collapse = $request->input('menu_is_collapse');
        $user->save();

        \Session::flash('message', trans('system.success'));
        \Session::flash('alert-class', 'success');

        return redirect()->route('admin.home');
    }

    public function contacts(Request $request)
    {
        $contacts = \App\Contact::orderBy('updated_at', 'DESC')->paginate(\App\Define\Constant::PAGE_NUM_20);

        return view('backend.contacts.index', compact('contacts'));
    }

    public function contact(Request $request, $id)
    {
        $id = intval($id);
        $contact = \App\Contact::find($id);
        if (is_null($contact))
            return redirect()->route('admin.contacts.index');

        return view('backend.contacts.show', compact('contact'));
    }

    public function staticPage($slug)
    {
        $page = StaticPage::where('slug', $slug)->where('status', 1)->first();
        if (is_null($page)) \App::abort('404', "Nội dung không tồn tại.");
        return view('backend.pages.static', compact('page'));
    }
}