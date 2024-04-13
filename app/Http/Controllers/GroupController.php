<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Group;
use Botble\Member\Models\Member;




class GroupController extends BaseController
{



    /**
     * Display a listing of the groups with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::paginate(10); // Customize the pagination as needed
        return view('groups.index', compact('groups'));
    }


    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000', // Adjust validation as necessary
        ]);

        $group = new Group;
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();
        
        // Check if there are members to add and the group is successfully created
        if($request->has('membersToAdd') && !empty($request->membersToAdd)) {
            // Assuming you have set up the many-to-many relationship in the Group model
            // Attach the selected members to the group
            $group->members()->attach($request->membersToAdd);
        }

        return redirect()->route('groups.index')->with('success', 'Group added successfully');
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->update($request->only(['name', 'description']));

        // Assuming 'membersToAdd' contains IDs of members to add
        if ($request->has('membersToAdd')) {
            $group->members()->syncWithoutDetaching($request->input('membersToAdd'));
        }

        return redirect()->route('groups.view', $group->id)->with('success', 'Group updated successfully');
    }

    public function removeMember(Request $request, $groupId, $memberId)
    {
        $group = Group::findOrFail($groupId);
        $group->members()->detach($memberId);

        return response()->json(['success' => true, 'message' => 'Member removed successfully']);
    }




    public function createView()
    {
        $allMembers=Member::all();

        return view('groups.create', compact('allMembers'));
    }

    public function editView($id)
    {
        $group = Group::findOrFail($id);
        $allMembers = Member::all();
        return view('groups.edit', compact('allMembers','group'));
    }

    public function groupView($id)
    {
        $group = Group::findOrFail($id);
        return view('groups.view', compact('group'));
    }

    public function edit(Request $request, $id)
    {
        // Validate request and update group information
    }

    public function delete($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully');
    }




    public function getMembersOfGroups(Request $request)
    {
        $groupIds = $request->groups;
        $membersToExclude = Member::whereIn('group_id', $groupIds)->pluck('email'); // Adjust according to your database structure
    
        return response()->json($membersToExclude);
    }



}
