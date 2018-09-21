<?php

namespace App\Http\Controllers\Api;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\Project as ProjectResource;
use Illuminate\Validation\Rule;

class ProjectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return ProjectCollection
     */
    public function index()
    {
        $clients = Project::all();

        return (new ProjectCollection($clients))->additional(['message' => 'Projects retrieved successfully.']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ProjectResource
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $this->sendError($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $project = Project::create([
            'name' => $input['name'],
            'description' => $input['description'],
            'statuses' => Project::STATUS_PLANNED,
        ]);

        return (new ProjectResource($project))->additional(['message' => 'Project created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return ProjectResource
     */
    public function show($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return $this->sendError('Project not found.');
        }

        return (new ProjectResource($project))->additional(['message' => 'Project retrieved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return bool
     */
    public function edit($id)
    {
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return ProjectResource
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'statuses' => [
                'required',
                Rule::in(Project::getStatuses()),
            ],
        ]);

        if ($validator->fails()) {
            $this->sendError($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $project = Project::find($id);

        if (!$project) {
            return $this->sendError('Project not found.');
        }


        $project->name = $input['name'];
        $project->description = $input['description'];
        $project->statuses = $input['statuses'];

        $project->save();

        return (new ProjectResource($project))->additional(['message' => 'Project updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return ProjectResource
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return $this->sendError('Project not found.');
        }

        $project->delete();

        return (new ProjectResource($project))->additional(['message' => 'Project deleted successfully.']);
    }
}
