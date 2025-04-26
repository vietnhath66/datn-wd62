<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class RoleService implements RoleServiceInterface
{
    protected $RoleRepository;

    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = addslashes($request->integer('per_page'));


        $brands = $this->RoleRepository->pagination(
            ['*'],
            $condition,
            $perPage,
            ['path' => 'admin/role/index'],
            ['id', 'DESC'],
            [],
            ['users'],
        );
        return $brands;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $role = $this->RoleRepository->create($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $role = $this->RoleRepository->findById($id);

            $updateBrand = $this->RoleRepository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function destroy($role)
    {
        DB::beginTransaction();
        try {
            $destroyBrand = $this->RoleRepository->destroy($role);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
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

            $updateUser = $this->RoleRepository->update($user, $payload);
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

            $flag = $this->RoleRepository->updateByWhereIn('id', $post['id'], $payload);

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

    public function customerStatistic()
    {
        return [
            'totalCustomers' => $this->RoleRepository->totalCustomer(),
        ];
    }

    private function payload()
    {
        return [
            "name",
            "image",
        ];
    }
}
