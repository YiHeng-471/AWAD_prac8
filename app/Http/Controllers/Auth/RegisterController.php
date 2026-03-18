<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller {
	use RegistersUsers;
	protected $redirectTo = '/home';
	public function __construct() {
		$this->middleware('guest');
		$this->middleware('guest:admin');
		$this->middleware('guest:author');
	}
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:6', 'confirmed'],
		]);
	}
	public function showAdminRegisterForm() {
		return view('auth.register', ['url' => 'admin']);
	}
	public function showAuthorRegisterForm() {
		return view('auth.register', ['url' => 'author']);
	}
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}
	protected function createAdmin(Request $request) {
		$this->validator($request->all())->validate();
		Admin::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);
		return redirect()->intended('login/admin');
	}
	protected function createAuthor(Request $request) {
		$this->validator($request->all())->validate();
		Author::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);
		return redirect()->intended('login/author');
	}
}
