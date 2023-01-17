<?php

namespace App\Http\Controllers;

use App\Event\AddNotification;
use App\Http\Requests\UserCreate;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', [
            'users' => $this->userRepository->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreate $request)
    {
        $clearData = $request->validated();

        $user = $this->userRepository->create($clearData);
        if (!Gate::any('isSuperAdmin')) abort(403);
        return redirect()
            ->route('user.show');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('user.show', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusRepository $statusRepository, int $id)
    {
        $employee = $this->userRepository->findOrFail($id);
        if (!Gate::any('userChangePermissions', [$employee])) abort(403);

        $filtersNotAccepted = [
            'user_id' => $id,
            'accepted' => 0,
        ];

        $filtersAccepted = [
            'user_id' => $id,
            'accepted' => 1,
        ];

        return view('user.edit', [
            'user' => $employee,
            'statusesNotAccepted' => $statusRepository->get($filtersNotAccepted),
            'statusesAccepted' => $statusRepository->get($filtersAccepted),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserCreate $request, int $id)
    {
        $employee = $this->userRepository->findOrFail($id);
        if (!Gate::any('myAccount', [$id]) & !Gate::any('userChangePermissions', [$employee])) {
            abort(403);
        }

        $clearData = $request->validated();
        $this->userRepository->update($clearData, $employee);
        event(new AddNotification('Update profil!!', $employee->id, route('user.edit', [
            'id' => $id
        ])));
        if (Gate::any('myAccount', [$id])) {
            return redirect()
                ->route('user.show');
        }
        return redirect()
            ->route('user.edit', [
                'id' => $id
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}