<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\CounponRepositoryInterface as CounponRepository;
use App\Services\Interfaces\CounponServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserService
 * @package App\Services
 */
class CounponService implements CounponServiceInterface
{
    protected $CounponRepository;

    public function __construct(CounponRepository $CounponRepository)
    {
        $this->CounponRepository = $CounponRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = addslashes($request->integer('per_page'));


        $brands = $this->CounponRepository->pagination(
            ['*'],
            $condition,
            $perPage,
            ['path' => 'admin/counpon/index'],
            ['id', 'DESC'],
            [],
            [],
        );
        return $brands;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['number'] = 1;

            $counpon = $this->CounponRepository->create($payload);
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
            $counpon = $this->CounponRepository->findById($id);

            if ($request->hasFile('image')) {
                $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            }

            $currentImage = $counpon->image;

            if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }

            $updateCounpon = $this->CounponRepository->update($id, $payload);
            if (!$updateCounpon) {
                throw new \Exception("Cập nhật khuyến mãi thất bại");
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function destroy($counpon)
    {
        DB::beginTransaction();
        try {
            $destroyCounpon = $this->CounponRepository->destroy($counpon);
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

            $updateUser = $this->CounponRepository->update($user, $payload);
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

            $flag = $this->CounponRepository->updateByWhereIn('id', $post['id'], $payload);

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
            'totalCustomers' => $this->CounponRepository->totalCustomer(),
        ];
    }

    private function payload()
    {
        return [
            'name',
            'code',
            'discount_type',
            'discount_value',
            'number',
            'minimum_order_amount',
            'start_date',
            'end_date',
        ];
    }
}
