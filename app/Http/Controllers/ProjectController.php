<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = new Project();

            if ($request->search['value']) {
                $search   = $request->search['value'];
                $projects = $projects->where('name', 'like', '%' . $search . '%');
            }

            $order = $request->columns[$request->order[0]['column']]['name'];
            $dir   = $request->order[0]['dir'];

            if ($order == 'name') {
                $projects = $projects->orderBy('name', $dir);
            } else {
                $projects = $projects->orderBy($order, $dir);
            }

            $offset = $request->start ?: 0;
            $limit  = $request->length ?: 10;

            $projects     = $projects->orderBy('id', 'desc');
            $clientTotal = $projects->get();
            $projects     = $projects->skip($offset)->take($limit)->get();

            $projectsList  = [];

            if (!empty($projects)) {
                foreach ($projects as $index => $project) {
                    $currentData   = [];
                    $currentData[] = '<div class="checkbox-inline"> <div class="checkbox-inline">' .
                        '<input type="checkbox" class="checkbox-inline chkbox" name="id" data-id="'. $project->id .'">' .
                        '<label for="id' . $project->id . '"></label></div></div>';
                    $currentData[] = $index + 1;
                    $currentData[] = $project->name;
                    $currentData[] = ($project->status == 1) ? '<span class="text text-primary">Active</span>' : '<span class="text text-danger">In-active</span> ';
                    $currentData[] = '<div class="d-flex">
                     <a href="' . route('projects.edit', $project->id) . '" class="btn btn-primary mr-9">Edit</a>
                     <a href="javascript:void(0);" onClick="deleteRecord(' . $project->id . ')" class="btn btn-danger">Delete</a> </div>';
                    $projectsList[]  = $currentData;
                }
            }

            $json_data = [
                "draw"            => intval($request['draw']),
                "data"            => $projectsList,
                "recordsTotal"    => count($clientTotal),
                "recordsFiltered" => count($clientTotal)
            ];
            return response()->json($json_data);
        }

        return view('projects.index');
    }

    /**
     * Show the form for creating a new project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'status' => ['required'],
        ]);

        if ($request->ajax()) {
            Project::create([
                'name'   => $request->name,
                'status' => $request->status ? $request->status : 1,
            ]);

            $request->session()->flash('success', 'project created successfully');

            return response()->json([
                'message' => 'project created successfully',
                'status'  => 'success',
                'code'    => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Access denied',
                'status'  => false,
                'code'    => 404
            ]);
        }
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.update', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'   => ['required'],
            'status' => ['required'],
        ]);

        if ($request->ajax()) {
            $project->name   = $request->name;
            $project->status = $request->status == 1 ? 1 : 0;
            $project->save();

            $request->session()->flash('success', 'Updated successfully');

            return response()->json([
                'message' => 'Updated successfully',
                'status'  => 'success',
                'code'    => 200
            ]);
        } else {
            return response()->json([
                'message' => 'No access',
                'status'  => false,
                'code'    => 404
            ]);
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'ids' => ['required'],
        ]);

        if ($request->ajax()) {
            $ids = explode(",", $request->ids);
            Project::whereIn('id', $ids)->delete();

            return response()->json([
                'message' => 'Project deleted successfully',
                'status'  => 'success',
                'code'    => 200
            ]);
        } else {
            return response()->json([
                'message' => 'No access',
                'status'  => false,
                'code'    => 404
            ]);
        }
    }
}
