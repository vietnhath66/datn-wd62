<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as userRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends BaseService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(userRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
    
        // Lấy theo status nếu có truyền vào
        if ($request->has('is_locked')) {
            $condition['is_locked'] = $request->integer('is_locked');
        }
    
        $condition['publish'] = $request->integer('publish');
    
        $perPage = $request->integer('per_page') ?? 10;
    
        $users = $this->userRepository->pagination(
            ['users.*'],
            $condition,
            $perPage,
            ['path' => 'admin/users/index'],
            ['users.id', 'DESC'],
            [['roles as tb2', 'tb2.id', '=', 'users.role_id']],
            ['roles'],
        );
    
        return $users;
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $data['birthday'] = $this->convertBirthdayDate($data['birthday']);
            // dd($data);
            $user = $this->userRepository->create($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            // die();
            return false;
        }
    }

    public function update($data, $user)
    {
        // dd($data, $user);
        DB::beginTransaction();
        try {

            // $data['password'] = Hash::make($data['password']);
            // $data['birthday'] = $this->convertBirthdayDate($data['birthday']);
            $updateUser = $this->userRepository->update($user, $data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function destroy($user)
    {
        DB::beginTransaction();
        try {
            if ($user instanceof \Illuminate\Database\Eloquent\Collection) {
                foreach ($user as $singleUser) {
                    $singleUser->delete();
                }
            } else {
                $user->delete();
            }
    
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Ném lại lỗi để controller bắt được
        }
    }
    

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            // dd($post);

            $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);

            // dd($payload);
            $user = User::find($post['modelId']);

            $updateUser = $this->userRepository->update($user, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatusAll($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];

            $flag = $this->userRepository->updateByWhereIn('id', $post['id'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    private function convertBirthdayDate($birthday = '')
    {
        $carbonDate = Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday = $carbonDate->format('Y-m-d H:i:s');

        return $birthday;
    }
    public function getLockedUsers($request)
{
    return User::where('is_locked', 1)->paginate(10);
}
}
