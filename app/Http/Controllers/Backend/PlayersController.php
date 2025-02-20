<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Player;
use App\Models\Backend\Team;

class PlayersController extends Controller
{
    public function index(){
        
        $players = Player::where('team', '')
                     ->orWhereNull('team')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('backend.players.index', compact('players'));
    }

    public function create(){
        
        
        return view('backend.players.addplayer');
    }

    public function storePlayer(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/player-images'), $imageName);
        }else{
            $imageName = '';
        }

        // Store player data
        Player::create([
            'name' => $request->input('name'),
            'image' => $imageName,
            'role' => $request->input('role'),
        ]);

        return redirect()->route('players')->with('success', 'Player added successfully!');
    }

    public function editPlayer($id){
        $old = Player::find($id);
        return view('backend.players.addplayer', compact('old'));
    }


    public function updatePlayer(Request $request, $id) {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string',
        ]);
    
        // Find the player
        $player = Player::find($id);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('backend/player-images'), $imageName);
    
            // Remove old image if new one is uploaded
            if ($player->image && file_exists(public_path('backend/player-images/' . $player->image))) {
                unlink(public_path('backend/player-images/' . $player->image));
            }
    
            $player->image = $imageName;
        }
    
        // Update player data
        $player->name = $request->input('name');
        $player->role = $request->input('role');
        $player->save();
    
        return redirect()->route('players')->with('success', 'Player updated successfully!');
    }

    public function viewPlayer($id){
        $old = Player::find($id);
        $teams = Team::all();
        return view('backend.players.viewplayer', compact('old','teams'));
    }

    public function updatePlayerInfo(Request $request) {
        // Validate form data
        $validated = $request->validate([
            'player_id' => 'required|exists:players,id',
            'point' => 'required|integer|min:0',
            'team' => 'required|exists:teams,id',
        ]);
    
        // Find the player by ID
        $player = Player::find($request->input('player_id'));
        $point = Player::where('team',$request->input('team'))->sum('point');
        $point += $request->input('point');
        if($point > 3000){
            
            return redirect()->route('players')->with('failed', 'Insufficient Available Points! Total team points exceed 3000.');
        }else{
            // Update player points and team
            $player->point = $request->input('point');
            $player->team = $request->input('team');
            
            // Save the updated player
            $player->save();
        }
        
    
        // Redirect with success message
        return redirect()->route('players')->with('success', 'Player information updated successfully!');
    }

    public function deletePlayer($id) {
        $player = Player::find($id);
    
        // Check if player has an image, and if it exists in the folder
        if ($player->image && file_exists(public_path('backend/player-images/' . $player->image))) {
            unlink(public_path('backend/player-images/' . $player->image)); // Delete the image
        }
    
        // Delete the player from the database
        $player->delete();
    
        return redirect()->route('players')->with('success', 'Player and their image deleted successfully! 🗑️');
    }

    public function teamPlayers()
    {
        // Get all teams with their associated players
        $teams = Team::with('players')->get();
        
        // Pass the teams to the view
        return view('backend.players.teamplayers', compact('teams'));
    }

    


}
