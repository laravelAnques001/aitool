<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneratorRequest;
use App\Models\Generator as ModelsGenerator;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tool = '')
    {
        if ($tool != '') {
            $search = $request->search;
            if ($search) {
                $generator = ModelsGenerator::select('id', 'tool_id', 'logo', 'image', 'name', 'description', 'link', 'created_at')
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('tool_id', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->where('tool_id', base64_decode($tool))
                    ->where('status', 1)
                    ->whereNull('deleted_at')
                    ->paginate(10);
            } else {
                $generator = ModelsGenerator::select('id', 'tool_id', 'logo', 'image', 'name', 'description', 'link', 'created_at')
                    ->where('tool_id', base64_decode($tool))
                    ->where('status', 1)
                    ->whereNull('deleted_at')
                    ->paginate(10);
            }
            return $this->sendResponse($generator, 'Generator Show SuccessFully.');
        }
        return $this->sendError([], 'Tool Id Required.');
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
        $generator = ModelsGenerator::create($validated);
        return $this->sendResponse($generator->id, 'Generator Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $generator = ModelsGenerator::select('id', 'tool_id', 'logo', 'image', 'name', 'description', 'link', 'created_at')
            ->where('id', base64_decode($id))
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->first();
        if ($generator) {
            return $this->sendResponse($generator, 'Generator Show SuccessFully.');
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
    public function update(GeneratorRequest $request, $id)
    {
        $generator = ModelsGenerator::whereNull('deleted_at')->find(base64_decode($id));
        if (!$generator) {
            return $this->sendError([], 'Record Not Found.');
        }

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
        return $this->sendResponse([], 'Generator Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $generator = ModelsGenerator::whereNull('deleted_at')->find(base64_decode($id));
        if ($generator) {
            $generator->fill(['deleted_at' => now()])->save();
            return $this->sendResponse([], 'Generator Deleted Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }
}
