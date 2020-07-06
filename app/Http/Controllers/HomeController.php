<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    
    protected $users = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $users)
    {
        $this->middleware('auth');
        $this->users = $users;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function listUsers()
    {
        $users = $this->users->paginate(10);

        return response()->json([
            'success'       => true,
            'data'          => new UserCollection($users),
            'pagination'    => [
                                'total'         => $users->total(),
                                'current_page'  => $users->currentPage(),
                                'per_page'      => $users->perPage(),
                                'last_page'     => $users->lastPage(),
                                'from'          => $users->firstItem(),
                                'to'            => $users->lastItem(),
                            ],
            'message'       => __('Users List'),
        ], Response::HTTP_OK);
    }
}
