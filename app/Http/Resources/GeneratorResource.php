<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneratorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'link' => $this->link,
            'image_url' => $this->image_url,
            'logo_url' => $this->logo_url,
            'description' => $this->description,
            'tool_id' => $this->tool_id,
            'tool' => new ToolResource($this->tool) ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
