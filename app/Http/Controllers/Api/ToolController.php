<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToolRequest;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = isset($request->search) ? $request->search : null;
        $top = isset($request->top) ? $request->top : null;
        if ($search) {
            $tools = Tool::select('id', 'name', 'image', 'created_at')->where('name', 'like', '%' . $search . '%')->where('status', 1)->whereNull('deleted_at')->paginate(10);
        } elseif ($top) {
            $tools = Tool::select('id', 'name', 'image', 'created_at')->where('status', 1)->whereNull('deleted_at')->inRandomOrder()->limit($top)->get();
        } else {
            $tools = Tool::select('id', 'name', 'image', 'created_at')->where('status', 1)->whereNull('deleted_at')->paginate(10);
        }
        return $this->sendResponse($tools, 'Tools List Get SuccessFully.');
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
        $tool = Tool::create($validated);
        return $this->sendResponse($tool->id, 'Tool Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tool = Tool::select('id', 'name', 'image', 'created_at')->where('status', 1)->whereNull('deleted_at')->find(base64_decode($id));
        if ($tool) {
            return $this->sendResponse($tool, 'Tools Show SuccessFully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
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
        $tool = Tool::whereNull('deleted_at')->find(base64_decode($id));
        if (!$tool) {
            return $this->sendError([], 'Record Not Found.');
        }

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
        return $this->sendResponse([], 'Tool Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tool = Tool::whereNull('deleted_at')->find(base64_decode($id));
        if ($tool) {
            $tool->fill(['deleted_at' => now()])->save();
            return $this->sendResponse([], 'Tool Deleted Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }
}
