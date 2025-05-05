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


        // dd($condition['keyword']);
        $brands = $this->BrandRepository->pagination(
            ['*'],
            $condition,
            $perPage,
            ['path' => 'admin/brand/index'],
            ['id', 'DESC'],
            [],
            [],
        );

        if (isset($_GET) && isset($condition['keyword'])) {

            $brands = Brand::where('name', 'LIKE', '%' . $condition['keyword'] . '%')->get();
        }
        return $brands;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            if ($request->hasFile('image')) {
                // Sửa lỗi: Chỉ định disk 'public' để lưu vào storage/app/public
                $payload['image'] = Storage::disk('public')->put(self::PATH_UPLOAD, $request->file('image'));

                // Hoặc dùng cách này:
                // $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'), 'public');
            }
            $brand = $this->BrandRepository->create($payload);
            DB::commit();
            return true; // Có thể trả về $brand hoặc redirect response nếu cần
        } catch (\Exception $e) {
            DB::rollBack();
            // Thay vì echo và die, nên log lỗi và trả về false hoặc response lỗi
            // echo $e->getMessage();
            // die();
            \Log::error('Lỗi tạo brand:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return false; // Hoặc response lỗi
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $brand = $this->BrandRepository->findById($id);

            if ($request->hasFile('image')) {
                $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            }

            $currentImage = $brand->image;

            if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }

            $updateBrand = $this->BrandRepository->update($brand, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
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
