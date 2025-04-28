<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Orders;

/**
 * Class UserService
 * @package App\Services
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(
        Order $model
    ) {
        $this->model = $model;
    }



    public function getOrderById(int $id = 0)
    {
        
        return $this->model
        ->select([
            'orders.id',
            'orders.user_id',
            'users.name as customer_name',
            'orders.email',
            'orders.phone',
            'orders.total',
            'orders.status',
            'orders.payment_status',
            'orders.payment_method',
            'orders.neighborhood',
            'orders.barcode',
            'orders.province',
            'orders.district',
            'orders.number_house',
            'orders.address',
            'orders.created_at',
            'orders.updated_at',
            'order_items.product_id',
            'products.name as product_name',
            'order_items.quantity',
            'order_items.price as product_price',
            'product_variants.name as variant_name',
            'product_variants.sku',
            'product_variants.name_variant_size',
            'product_variants.name_variant_color',
            'product_variants.price'
        ])
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('order_items', 'order_items.order_id', '=', 'orders.id')
        ->join('products', 'products.id', '=', 'order_items.product_id')
        ->join('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id') 
        ->where('orders.id', $id)
        ->first();
    }

    public function getOrderByUser(int $productCatalogueId = 0, $language_id = 0)
    {
        return $this->model->select(
            [
                'products.id',
                'products.product_catalogue_id',
                'products.image',
                'products.price',
                'tb2.name',
                'tb2.description',
                'tb2.canonical',
            ]
        )
            ->join('product_language as tb2', 'tb2.product_id', '=', 'products.id')
            ->with([
                'product_catalogues',
                'reviews'
            ])
            ->where('tb2.language_id', '=', $language_id)
            ->where('products.product_catalogue_id', '=', $productCatalogueId)
            ->get();
    }

    public function findProductForPromotion($condition = [], $relation = [])
    {
        $query = $this->model->newQuery();
        $query->select([
            'products.id',
            'products.image',
            'products.price',
            'tb2.name',
            'tb3.uuid',
            'tb3.id as product_variant_id',
            DB::raw("CONCAT(tb2.name, ' - ', COALESCE(tb4.name, ' Default')) as variant_name"),
            DB::raw("COALESCE(tb3.sku, products.code) as sku"),
            DB::raw("COALESCE(tb3.price, products.price) as price")
        ]);
        $query->join('product_language as tb2', 'products.id', '=', 'tb2.product_id');
        $query->leftJoin('product_variants as tb3', 'products.id', '=', 'tb3.product_id');
        $query->leftJoin('product_variant_language as tb4', 'tb3.id', '=', 'tb4.product_variant_id');

        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }

        if (count($relation)) {
            $query->with($relation);
        }
        $query->orderBy('id', 'DESC');

        return $query->paginate(20);
    }

    public function filter($param, $perpage)
    {
        $query = $this->model->newQuery();

        $query->select([
            'products.id',
            'products.price',
            'products.image',
            'products.product_catalogue_id',
        ]);

        if (isset($param['select']) && count($param['select'])) {
            foreach ($param['select'] as $key => $val) {
                $query->selectRaw($val);
            }
        }

        if (isset($param['join']) && count($param['join'])) {
            foreach ($param['join'] as $key => $val) {
                if (is_null($val)) continue;
                $query->leftJoin($val[0], $val[1], $val[2], $val[3]);
            }
        }

        $query->where('products.publish', '=', 1);

        if (isset($param['where']) && count($param['where'])) {
            foreach ($param['where'] as $key => $val) {
                $query->where($val);
            }
        }

        if (isset($param['having']) && count($param['having'])) {
            foreach ($param['having'] as $key => $val) {
                if (is_null($val)) continue;
                $query->having($val);
            
            }
        }
        if (isset($param['groupBy']) && count($param['groupBy'])) {
            foreach ($param['groupBy'] as $column) {
                $query->groupBy($column);
            }
        }

        // if (isset($param['whereRaw']) && count($param['whereRaw'])) {
        //     $query->whereRaw($param['whereRaw'][0][0],$param['whereRaw'][0][1]);
        // }
        $query->with(['reviews', 'languages', 'product_catalogues']);
        return $query->paginate($perpage);
    }

    private function convertAttributeFilter($attribute, $languageId, $catId)
    {
        $rawCondition['whereRaw'] =  [
            [
                'tb3.id IN (
                    SELECT id
                    FROM product_catalogues
                    JOIN product_catalogue_language ON product_catalogues.id = product_catalogue_language.product_catalogue_id
                    WHERE lft >= (SELECT lft FROM product_catalogues as pc WHERE pc.id = ?)
                    AND rgt <= (SELECT rgt FROM product_catalogues as pc WHERE pc.id = ?)
                    AND product_catalogue_language.language_id = ' . $languageId . '
                )',
                [$catId, $catId]
            ]
        ];
    }

    private function convertPriceFilter($price) {}

    private function convertRateFilter($rate) {}
}
