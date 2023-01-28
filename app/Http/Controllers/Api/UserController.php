<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Change\UserGroup;
use App\Http\Requests\Change\UserRole;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function changeRole(UserRole $request, int $id)
    {
        $this->userRepository->changeRole($id, $request->input('role_id', 0));

        return response()
            ->json([
                'msg' => "Success"
            ], 200);
    }

    public function changeGroup(UserGroup $request, int $id)
    {
        $this->userRepository->changeGroup($id, $request->input('group_id', 0));

        return response()
            ->json([
                'msg' => "Success"
            ], 200);
    }
}
