<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Repository\GroupRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Update\Group as UpdateGroup;
use App\Http\Requests\Create\Group as CreateGroup;

class GroupController extends Controller
{
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository) {
        $this->groupRepository = $groupRepository;
    }

    public function index()
    {
        return view('group.index', [
           'groups' => $this->groupRepository->get()
        ]);

    }
    public function edit(int $id)
    {
        return view('group.edit', [
            'group' => $this->groupRepository->findOrFail($id)
        ]);
    }
    public function show(int $id)
    {
        return view('group.show', [
            'group' => $this->groupRepository->findOrFail($id)
        ]);
    }

    public function store(CreateGroup $request) {

        $group = $this->groupRepository->create($request->only([
            'name',
            'available',
        ]));

        return redirect()
            ->route('group.show', [
                'id' => $group->id
            ]);
    }
    public function update(UpdateGroup $request, int $id) {
        $group = $this->groupRepository->update($request->only([
            'name',
            'available'
        ]), $id);

        return redirect()
            ->back();
    }

}
