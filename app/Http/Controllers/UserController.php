<?php

namespace App\Http\Controllers;

use App\Event\AddNotification;
use App\Event\NewUser;
use App\Http\Requests\Create\User as UserCreate;
use App\Http\Requests\Update\User as UserUpdate;
use App\Repository\GroupRepository;
use App\Repository\StatusRepository;
use App\Repository\UserRepository;
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
    public function index(GroupRepository $groupRepository)
    {
         return view('user.index', [
            'groups' => $groupRepository->get(),
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

        //event(new NewUser($user));
        return redirect()
            ->route('user.edit', [
                'id' => $user->id
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StatusRepository $statusRepository)
    {
        $filters = [
          'user_id' => Auth::id()
        ];

        return view('user.show', [
            'user' => Auth::user(),
            'statuses' => $statusRepository->get($filters, 15)
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

        if (!Gate::any('updateData', [$employee])) abort(403);

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
    public function update(UserUpdate $request, int $id)
    {
        $employee = $this->userRepository->findOrFail($id);
        if (!Gate::any('updateData', [$employee])) abort(403);

        $this->userRepository->update($request->only([
            "first_name",
            "last_name",
            "email_company",
            "email_private",
            "number_phone",
            "city",
            "zip_code",
            "street",
        ]), $id);

        return redirect()
            ->back();
    }
}
