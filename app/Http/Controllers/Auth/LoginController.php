<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
	use AuthenticatesUsers;
	protected $redirectTo = '/home';
	public function __construct() {
		$this->middleware('guest')->except('logout');
		$this->middleware('guest:admin')->except('logout');
		$this->middleware('guest:author')->except('logout');
	}

	public function showAdminLoginForm() {
		return view('auth.login', ['url' => 'admin']);
	}

	public function adminLogin(Request $request) {
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|min:6'
		]);
		if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
			return redirect()->intended('/admin');
		}
		return back()->withInput($request->only('email', 'remember'));
	}

	public function showAuthorLoginForm() {
		return view('auth.login', ['url' => 'author']);
	}

	public function authorLogin(Request $request) {
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|min:6'
		]);
		if (Auth::guard('author')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
			return redirect()->intended('/author');
		}
		return back()->withInput($request->only('email', 'remember'));
	}
}
