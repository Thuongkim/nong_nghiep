<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

use App\StaticPage;
use App\News;
use App\NewsCategory;
use App\Feedback;
use App\Slider;
use App\Experience;

use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::getSliders();
        $experiences = Experience::getByAll();
        $top4Categories = NewsCategory::getTop4ByPosition();
        return view('frontend.pages.home', compact('sliders', 'top4Categories', 'experiences'));
    }

    public function get404()
    {
        return view('frontend.pages.404');
    }

    public function staticPage($slug)
    {
        $page = StaticPage::where('slug', $slug)->where('status', 1)->first();
        if (is_null($page)) abort('404');
        $featuredNews = News::where('status', 1)->where('featured', 1)->orderBy('updated_at', 'DESC')->take(6)->get();
        $newsCategories = NewsCategory::getByAll();

        return view('frontend.pages.static', compact('page', 'featuredNews', 'newsCategories'));
    }

    public function getContact()
    {
        $featuredNews = News::where('status', 1)->where('featured', 1)->orderBy('updated_at', 'DESC')->take(6)->get();
        $newsCategories = NewsCategory::getByAll();
        return view('frontend.pages.contact', compact('featuredNews', 'newsCategories'));
    }

    public function getDetailNews(Request $request, $slug, $id)
    {
        $news = News::where('status', 1)->where('id', intval($id))->first();
        if (is_null($news)) \App::abort('404');
        $category = NewsCategory::where('status', 1)->where('id', $news->category_id)->first();
        if (is_null($category)) \App::abort('404', "Không tìm thấy tài nguyên bạn yêu cầu.");
        $featuredNews = News::where('status', 1)->where('featured', 1)->orderBy('updated_at', 'DESC')->take(6)->get();
        // $featuredNews = News::where('status', 1)->where('id', '<>', intval($id))->where('category_id', $news->category_id)->orderBy('updated_at', 'DESC')->take(6)->get();
        $otherCategories = NewsCategory::where('status', 1)->where('id', '<>', $news->category_id)->get();

        $rootCat = null;
        if ($category->parent_id) {
            $rootCat = NewsCategory::where('status', 1)->where('id', $category->parent_id)->first();
            if (is_null($rootCat)) \App::abort('404');
        }
        $newsCategories = NewsCategory::getByAll();
        return view('frontend.pages.detail_news', compact('news', 'category', 'lastNews', 'featuredNews', 'otherCategories', 'rootCat', 'newsCategories'));
    }

    public function getNewsCategory(Request $request, $slug, $id)
    {
        $category = NewsCategory::where('status', 1)->where('id', intval($id))->first();
        if (is_null($category)) abort('404');
        $childIds = NewsCategory::where('status', 1)->where('parent_id', $category->id)->pluck('id', 'id')->toArray();
        $news = News::where('status', 1)->whereIn('category_id', [$category->id] + $childIds)->orderBy('updated_at', 'DESC')->paginate(\App\Define\Constant::PAGE_NUM, ['*'],'trang');
        // $otherCategories = NewsCategory::where('status', 1)->where('id', '<>', intval($id))->get();
        $featuredNews = News::where('status', 1)->where('featured', 1)->orderBy('updated_at', 'DESC')->take(6)->get();
        // $featuredNews = News::where('status', 1)->where('featured', 1)->whereIn('category_id', [$category->id] + $childIds)->whereNotIn("id", array_column($news->toArray(), 'id', 'id'))->orderBy('updated_at', 'DESC')->take(6)->get();
        $rootCat = null;
        if ($category->parent_id) {
            $rootCat = NewsCategory::where('status', 1)->where('id', $category->parent_id)->first();
            if (is_null($rootCat)) \App::abort('404');
        }

        $newsCategories = NewsCategory::getByAll();
        return view('frontend.pages.news_category', compact('category', 'news', 'rootCat', 'featuredNews', 'newsCategories'));
    }

    public function contact(Request $request)
    {
        $validator = \Validator::make($data = $request->only('fullname', 'phone', 'email', 'content', 'subject'), Feedback::rules());
        $validator->setAttributeNames(trans('feedbacks'));
        if ($validator->fails()) {
            Session::flash('message', $validator->messages()->first());
            return back()->withInput();
        }
        Feedback::create($data);
        Session::flash('message', "Cám ơn Khách hàng đã gửi phản hồi tới chúng tôi!");
        return redirect()->route('notify');
    }

    public function consultant(Request $request)
    {
        $response = [ 'message' => trans('system.have_an_error') ];
        $statusCode = 200;
        if($request->ajax()) {
            try {
                $validator = \Validator::make($data = $request->only('fullname', 'phone', 'email', 'content'), Feedback::rules());
                $validator->setAttributeNames(trans('feedbacks'));
                if ($validator->fails()) throw new \Exception($validator->messages()->first(), 1);
                Feedback::create($data);
                Session::flash('message', "Thành công, cám ơn bạn đã gửi tư vấn cho chúng tôi!");
                $response['message'] = trans('system.success');
            } catch (\Exception $e) {
                if ($statusCode == 200) $statusCode = 500;
                $response['message'] = $e->getMessage();
            } finally {
                return response()->json($response, $statusCode);
            }
        } else {
            $statusCode = 405;
            return response()->json($response, $statusCode);
        }
    }

    public function notify()
    {
        $featuredNews = News::where('status', 1)->where('featured', 1)->orderBy('updated_at', 'DESC')->take(6)->get();
        $newsCategories = NewsCategory::getByAll();
        return view('frontend.notify', compact('featuredNews', 'newsCategories'));
    }

    public function search(Request $request)
    {
        $query = htmlentities($request->keyword);
        if (!$query) return redirect()->route('home');
        $items = News::where('status', 1)->where('title', 'like', "%" . $query . "%")->get();
        $featuredNews = News::where('status', 1)->where('featured', 1)->orderBy('updated_at', 'DESC')->take(6)->get();
        $newsCategories = NewsCategory::getByAll();
        return view('frontend.pages.search', compact('items', 'query', 'featuredNews', 'newsCategories'));
    }

    public function comment(Request $request)
    {
        $validator = \Validator::make($data = $request->only('g-recaptcha-response', 'fullname', 'phone', 'email', 'content', 'news_id'), Feedback::rules() + ['g-recaptcha-response' => 'required']);
        $validator->setAttributeNames(trans('feedbacks'));
        if ($validator->fails()) {
            Session::flash('message', $validator->messages()->first());
            return redirect()->to(url()->previous() . '#comment')->withInput();
        }
        $news = News::where('status', 1)->where('id', $data['news_id'])->first();
        if (is_null($news)) {
            Session::flash('message', "Đã có lỗi xảy ra, vui lòng thử lại sau!");
            return redirect()->to(url()->previous() . '#comment')->withInput();
        }
        $data['status'] = 0;
        $news->comments()->create($data);
        Session::flash('message', "Thành công! Cám ơn Khách hàng đã gửi nhận xét cho bài viết!");
        return redirect()->to(url()->previous() . '#comment');
    }
}