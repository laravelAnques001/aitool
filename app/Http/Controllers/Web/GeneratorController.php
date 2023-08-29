<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneratorRequest;
use App\Models\Generator;
use App\Models\Tool;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Generator.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $toolList = Tool::whereNull('deleted_at')->get();
        return view('Admin.Generator.create', compact('toolList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneratorRequest $request)
    {
        $validated = $request->validated();
        if ($image = $request->image) {
            $validated['image'] = $image->store('public/generator/image');
        }
        if ($logo = $request->logo) {
            $validated['logo'] = $logo->store('public/generator/logo');
        }
        Generator::create($validated);
        return redirect()->route('generator.index')->with('success', 'Generator Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $generator = Generator::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Generator.show', compact('generator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $toolList = Tool::whereNull('deleted_at')->get();
        $generator = Generator::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Generator.edit', compact('generator', 'toolList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GeneratorRequest $request, $id)
    {
        $generator = Generator::find(base64_decode($id)) ?? abort(404);

        $validated = $request->validated();
        if ($image = $validated['image'] ?? null) {
            if ($oldImage = $generator->image ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['image'] = $image->store('public/generator/image');
        }

        if ($logo = $validated['logo'] ?? null) {
            if ($oldImage = $generator->logo ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['logo'] = $logo->store('public/generator/logo');
        }

        $generator->fill($validated)->save();
        return redirect()->route('generator.index')->with('success', 'Generator Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $generator = Generator::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($generator) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getGeneratorData()
    {
        $data = Generator::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('active', function ($data) {
                $checked = ($data->status == 1) ? 'checked' : '';
                return '<input type="checkbox" id="switcherySize2"  data-value="' . base64_encode($data->id) . '"  class="switchery switch" data-size="sm" ' . $checked . '  />';
            })
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('generator.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('generator.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('generator.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('image', function ($data) {
                if ($data->image_url) {
                    return '<img src="' . $data->image_url . '" alt="Generator Image" width="60" height="60"  class="img-thumbnail">';
                }
                return;
            })
            ->editColumn('link', function ($data) {
                if ($data->link) {
                    return '<a href="' . $data->link . '"  title="Generator Link" target="_blank">' . $data->link . '</a>';
                }
                return;
            })
            ->editColumn('logo', function ($data) {
                if ($data->logo_url) {
                    return '<img src="' . $data->logo_url . '" alt="Generator Logo" class="img-thumbnail" width="60" height="60" >';
                }
                return;
            })
            ->editColumn('description', function ($data) {
                if ($str = $data->description) {
                    return mb_strimwidth($str, 0, 100, "...");
                }
                return;
            })
            ->rawColumns(['date', 'action', 'image', 'logo', 'link', 'active', 'description'])
            ->addIndexColumn()
            ->toJson();
    }
    public function status($id, $status)
    {
        $generator = Generator::where('id', base64_decode($id))->update(['status' => $status]);
        if ($generator) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
