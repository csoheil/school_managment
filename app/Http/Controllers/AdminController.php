<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Class;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
public function __construct()
{
$this->middleware(['role:admin']);
}

// Show admin dashboard
public function index()
{
$stats = [
'students' => User::role('student')->count(),
'teachers' => User::role('teacher')->count(),
'classes' => Class::count(),
];
return view('admin.dashboard', compact('stats'));
}

// Register a new student or teacher
public function register(Request $request)
{
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users,email',
'password' => 'required|string|min:8',
'role' => 'required|in:student,teacher',
'avatar' => 'nullable|image|max:2048', // Max 2MB
]);

$user = User::create([
'name' => $request->name,
'email' => $request->email,
'password' => bcrypt($request->password),
'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null,
]);

$user->assignRole($request->role);
return redirect()->route('admin.dashboard')->with('success', 'User registered.');
}

// Delete a user
public function delete($id)
{
$user = User::findOrFail($id);
$user->delete();
return redirect()->route('admin.dashboard')->with('success', 'User deleted.');
}
}
