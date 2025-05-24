<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\User;
use App\Repositories\Interfaces\BrandRepositoryInterface as BrandRepository;
use App\Services\Interfaces\BrandServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserService
 * @package App\Services
 */
class BrandService implements BrandServiceInterface
{
    const PATH_UPLOAD = 'brands';
    protected $BrandRepository;

    public function __construct(BrandRepository $BrandRepository)
    {
        $this->BrandRepository = $BrandRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perPage = addslashes($request->integer('per_page'));

        $brands = $this->BrandRepository->pagination(
            ['*'],
            $condition,
            $perPage,
            ['path' => 'admin/brand/index'],
            ['id', 'DESC'],
            [],
            [],
        );

        if (isset($condition['keyword'])) {
            $brands = Brand::where('name', 'LIKE', '%' . $condition['keyword'] . '%')->paginate($perPage);
        }

        return $brands;
    }


    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/brands'), $imageName);
                $payload['image'] = 'brands/' . $imageName;
            }
            $brand = $this->BrandRepository->create($payload);

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
            // Kiểm tra xem Brand có tồn tại không
            $brand = $this->BrandRepository->getBrandById($id);
            if (!$brand) {
                throw new \Exception("Không tìm thấy thương hiệu với ID: $id");
            }

            // Lấy dữ liệu cần cập nhật
            $payload = $request->only($this->payload());

            // Kiểm tra và xử lý ảnh
            // if ($request->hasFile('image')) {
            //     $newImage = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            //     if ($newImage) {
            //         $payload['image'] = $newImage;
            //         // Xóa ảnh cũ nếu có
            //         if ($brand->image && Storage::exists($brand->image)) {
            //             Storage::delete($brand->image);
            //         }
            //     }
            // }
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu tồn tại
                if ($brand->image && file_exists(public_path('storage/' . $brand->image))) {
                    unlink(public_path('storage/' . $brand->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/brands'), $imageName);

                // Gán tên ảnh mới vào payload
                $payload['image'] = 'brands/' . $imageName;
            }

            // Cập nhật thương hiệu
            $updateBrand = $this->BrandRepository->update($id, $payload);
            if (!$updateBrand) {
                throw new \Exception("Cập nhật thương hiệu thất bại");
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Lỗi cập nhật thương hiệu: " . $e->getMessage()); // Ghi log thay vì die()
            return false;
        }
    }


    public function destroy($brand)
    {
        DB::beginTransaction();
        try {
            $destroyBrand = $this->BrandRepository->destroy($brand);
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

            $updateUser = $this->BrandRepository->update($user, $payload);
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

            $flag = $this->BrandRepository->updateByWhereIn('id', $post['id'], $payload);

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
            'totalCustomers' => $this->BrandRepository->totalCustomer(),
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
