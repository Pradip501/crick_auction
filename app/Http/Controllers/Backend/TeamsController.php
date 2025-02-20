<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Team;

class TeamsController extends Controller
{
    public function index(){
        
        $teams = Team::orderBy('created_at', 'desc')
                     ->get();

        return view('backend.teams.index', compact('teams'));
    }

    public function create(){
        
        
        return view('backend.teams.addteam');
    }

    public function storeteam(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/team-images'), $imageName);
        }else{
            $imageName = '';
        }

        // Store team data
        Team::create([
            'name' => $request->input('name'),
            'image' => $imageName,
        ]);

        return redirect()->route('teams')->with('success', 'team added successfully!');
    }

    public function editteam($id){
        $old = Team::find($id);
        return view('backend.teams.addteam', compact('old'));
    }

    public function updateteam(Request $request, $id) {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Find the team
        $team = Team::find($id);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/team-images'), $imageName);
    
            // Remove old image if new one is uploaded
            if ($team->image && file_exists(public_path('backend/team-images/' . $team->image))) {
                unlink(public_path('backend/team-images/' . $team->image));
            }
    
            $team->image = $imageName;
        }
    
        // Update team data
        $team->name = $request->input('name');
        $team->save();
    
        return redirect()->route('teams')->with('success', 'team updated successfully!');
    }



    public function deleteteam($id) {
        $team = Team::find($id);
    
        // Check if team has an image, and if it exists in the folder
        if ($team->image && file_exists(public_path('backend/team-images/' . $team->image))) {
            unlink(public_path('backend/team-images/' . $team->image)); // Delete the image
        }
    
        // Delete the team from the database
        $team->delete();
    
        return redirect()->route('teams')->with('success', 'team and their image deleted successfully! 🗑️');
    }
    


}
