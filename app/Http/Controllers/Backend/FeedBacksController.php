<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use App\Contact as Contact;
use App\ContactDetail as ContactDetail;
use App\Feedback as Feedback;

class FeedbacksController extends Controller
{
    public function index(Request $request)
    {
        $query = "1=1";
        $status         = intval($request->input('status', -1));
        $date_range     = $request->input('date_range');
        $page_num       = intval($request->input('page_num', \App\Define\Constant::PAGE_NUM_20));
        $fullname_email = $request->input('fullname_email');

        if($fullname_email) $query .= " AND (fullname like '%" . $fullname_email . "%' OR email like '%" . $fullname_email . "%')";
        if($status <> -1) $query .= " AND status = {$status}";
        if ($date_range)
            $date_range = explode(' - ', $date_range);
        if (isset($date_range[0]) && isset($date_range[1]))
            $query .= " AND created_at >= '" . date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', ($date_range[0] == '' ? '1/1/2015' : $date_range[0]) ))) . "' AND updated_at <= '" . date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', ($date_range[1] == '' ? date("d/m/Y") : $date_range[1]) ))) . "'";
        $feedbacks = Feedback::whereRaw($query)->orderBy('updated_at', 'DESC')->paginate($page_num);

        return view('backend.feedbacks.index', compact('feedbacks'));
    }

    public function show($id)
    {
        $feedback = Feedback::find(intval($id));
        if (is_null($feedback)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return redirect()->route('admin.feedbacks.index');
        }

        return view('backend.feedbacks.show', compact('feedback'));
    }

    public function edit($id)
    {
        $feedback = Feedback::find(intval($id));
        if (is_null($feedback)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return redirect()->route('admin.feedbacks.index');
        }
        return view('backend.feedbacks.edit', compact('feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::find(intval($id));
        if (is_null($feedback)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return redirect()->route('admin.feedbacks.index');
        }
        $request->merge(['status' => $request->input('status', 0)]);
        $validator = \Validator::make($data = $request->only('status', 'fullname', 'phone', 'email', 'content'), Feedback::rules());
        $validator->setAttributeNames(trans('feedbacks'));
        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();
        $feedback->update($data);
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.feedbacks.index');
    }

    public function destroy($id)
    {
        $feedback = Feedback::find(intval($id));
        if (is_null($feedback)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'error');
            return redirect()->route('admin.feedbacks.index');
        }
        $feedback->delete();

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');
        return redirect()->route('admin.feedbacks.index');
    }

    public function updateBulk(Request $request)
    {
        $response = ['success' => 0, 'message' => trans('system.have_an_error')];
        $statusCode = 200;
        if($request->ajax()) {
            try {
                $ids = json_decode($request->input('ids'));
                if(empty($ids)) {
                    $statusCode = 400;
                    throw new \Exception(trans('system.no_item_selected'), 1);
                }

                switch ($request->input('action')) {
                    case 'delete':
                        foreach ($ids as $id) Feedback::where('id', $id)->delete();
                        break;
                    case 'active':
                        foreach ($ids as $id) Feedback::where('id', $id)->update(['status' => 1]);
                        break;
                    case 'deactive':
                        foreach ($ids as $id) Feedback::where('id', $id)->update(['status' => 0]);
                        break;
                    default:
                        $statusCode = 400;
                        throw new \Exception(trans('system.no_action_selected'), 1);
                }

                $response['success'] = 1;
                $response['message'] = trans('system.success');
                Session::flash('message', $response['message']);
                Session::flash('alert-class', 'success');
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
}