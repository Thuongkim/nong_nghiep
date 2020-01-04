<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

use App\Experience as Experience;

class ExperiencesController extends Controller
{
    public function index(Request $request)
    {
        $query = "1=1";
        $status                 = intval($request->input('status', -1));
        if($status <> -1) $query .= " AND status = {$status}";

        $experiences = Experience::whereRaw($query)->orderBy('position')->get();

        return view('backend.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('backend.experiences.create');
    }

    public function show($id)
    {
        $experience   = Experience::find(intval($id));
        if (is_null($experience)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.experiences.index');
        }

        return view('backend.experiences.show', compact('experience'));
    }

    public function edit($id)
    {
        $experience   = Experience::find(intval($id));
        if (is_null($experience)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.experiences.index');
        }

        return view('backend.experiences.edit', compact('experience'));
    }

    public function store(Request $request)
    {
        $request->merge(['status' => $request->input('status', 0)]);
        $validator = \Validator::make($data = $request->all(), Experience::rules());
        $validator->setAttributeNames(trans('experiences'));
        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        if ($request->hasFile('image')) {
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height()/$image->width() <> \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT/\App\Define\Constant::IMAGE_EXPERIENCE_WIDTH) {
                Session::flash('message', "Ảnh đại diện phải có kích thước là " . \App\Define\Constant::IMAGE_EXPERIENCE_WIDTH ."px x " . \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }
            \File::makeDirectory(public_path(config('upload.experience') . date('dm')), 0777, true, true);
            $fileName = str_slug($data['fullname']). "-" . time() . '.' .  $ext;
            $image->resize(\App\Define\Constant::IMAGE_EXPERIENCE_WIDTH, \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT)->save(public_path(config('upload.experience') . date('dm') . '/' . $fileName));
            $data['image'] = config('upload.experience') . date('dm') . '/' . $fileName;
        }
        // $data['created_by'] = $request->user()->id;
        $data['position']   = 1;
        $experience = Experience::create($data);
        Experience::where('id', "<>", $experience->id)->increment('position');

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.experiences.index');
    }

    public function update(Request $request, $id)
    {
        $experience   = Experience::find(intval($id));
        if (is_null($experience)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.experiences.index');
        }

        $request->merge(['status' => $request->input('status', 0)]);
        $validator = \Validator::make($data = $request->all(), Experience::rules(intval($id)));
        $validator->setAttributeNames(trans('experiences'));

        if ($validator->fails()) return back()->withErrors($validator)->withInput();
        if ($request->hasFile('image')) {
            if (\File::exists(public_path() . '/' . $experience->image)) \File::delete(public_path() . '/' . $experience->image);
            $image  = $request->image;
            $ext    = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $image  = \Image::make($request->image);
            if ($image->height()/$image->width() <> \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT/\App\Define\Constant::IMAGE_EXPERIENCE_WIDTH) {
                Session::flash('message', "Ảnh đại diện phải có kích thước là " . \App\Define\Constant::IMAGE_EXPERIENCE_WIDTH ."px x " . \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT . "px.");
                Session::flash('alert-class', 'danger');
                return back()->withInput();
            }
            \File::makeDirectory(public_path(config('upload.experience') . date('dm')), 0777, true, true);
            $fileName = str_slug($data['fullname']). "-" . time() . '.' .  $ext;
            $image->resize(\App\Define\Constant::IMAGE_EXPERIENCE_WIDTH, \App\Define\Constant::IMAGE_EXPERIENCE_HEIGHT)->save(public_path(config('upload.experience') . date('dm') . '/' . $fileName));
            $data['image'] = config('upload.experience') . date('dm') . '/' . $fileName;
        }

        $experience->update($data);
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return redirect()->route('admin.experiences.index');
    }

    public function destroy($id)
    {
        $experience   = Experience::find(intval($id));
        if (is_null($experience)) {
            Session::flash('message', trans('system.have_an_error'));
            Session::flash('alert-class', 'danger');
            return redirect()->route('admin.experiences.index');
        }

        Experience::where('position', '>', $experience->position)->decrement('position');
        if (\File::exists(public_path() . '/' . $experience->image)) \File::delete(public_path() . '/' . $experience->image);
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');
        return redirect()->route('admin.experiences.index');
    }

    public function updatePosition($id, $value)
    {
        if (!in_array($value, [-1, 1])) return back();

        $experience = Experience::find(intval($id));

        if(is_null($experience)) return back();

        // tang len 1 vi tri
        if($value == 1) {
            if ($experience->position == Experience::count())
                return back();

            Experience::where('position', $experience->position + 1)->decrement('position');
            $experience->position++;
            $experience->save();
        } elseif($value == -1) {
            if ($experience->position == 1)
                return back();

            Experience::where('position', $experience->position - 1)->increment('position');
            $experience->position--;
            $experience->save();
        }

        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');

        return back();
    }
}