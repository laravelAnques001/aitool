<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToolRequest;
use App\Models\Tool;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Tool.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Tool.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ToolRequest $request)
    {
        $validated = $request->validated();
        if ($image = $request->image) {
            $validated['image'] = $image->store('public/tool');
        }
        Tool::create($validated);
        return redirect()->route('tool.index')->with('success', 'Tool Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tool = Tool::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Tool.show', compact('tool'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tool = Tool::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Tool.edit', compact('tool'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ToolRequest $request, $id)
    {
        $tool = Tool::find(base64_decode($id)) ?? abort(404);

        $validated = $request->validated();
        if ($image = $validated['image'] ?? null) {
            if ($oldImage = $tool->image ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['image'] = $image->store('public/tool');
        }

        $tool->fill($validated)->save();
        return redirect()->route('tool.index')->with('success', 'Tool Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tool = Tool::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($tool) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getToolData()
    {
        $data = Tool::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('active', function ($data) {
                $checked = ($data->status == 1) ? 'checked' : '';
                return '<input type="checkbox" id="switcherySize2"  data-value="' . base64_encode($data->id) . '"  class="switchery switch" data-size="sm" ' . $checked . '  />';
            })
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('tool.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('tool.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('tool.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('image', function ($data) {
                if ($data->image_url) {
                    return '<img src="' . $data->image_url . '" alt="Category" width="60" height="60" class="img-thumbnail">';
                } else {
                    return;
                }
            })
            ->rawColumns(['date', 'action', 'image', 'active'])
            ->addIndexColumn()
            ->toJson();
    }

    public function status($id,$status)
    {
        $tool = Tool::where('id', base64_decode($id))->update(['status' => $status]);
        if ($tool) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
