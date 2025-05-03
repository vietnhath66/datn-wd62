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
                'orders.ward_code',
                'orders.barcode',
                'orders.province_code',
                'orders.district_code',
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
                if (is_null($val))
                    continue;
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
                if (is_null($val))
                    continue;
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
        $rawCondition['whereRaw'] = [
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

    public function getOrderByTime($month, $year)
    {
        return $this->model
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();
    }


    public function revenueOrders()
    {
        return $this->model
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', '=', 'paid')
            ->sum(DB::raw('order_items.price * order_items.quantity'));
    }

    public function revenueByYear($year)
    {
        return $this->model->select(
            DB::raw('
            months.month, 
            COALESCE(SUM(orders.total),0) as monthly_revenue
        ')
        )
            ->from(DB::raw('(
                SELECT 1 AS month
                UNION SELECT 2
                UNION SELECT 3
                UNION SELECT 4
                UNION SELECT 5
                UNION SELECT 6
                UNION SELECT 7
                UNION SELECT 8
                UNION SELECT 9
                UNION SELECT 10
                UNION SELECT 11
                UNION SELECT 12
            ) as months'))
            ->leftJoin('orders', function ($join) use ($year) {
                $join->on(DB::raw('months.month'), '=', DB::raw('MONTH(orders.created_at)'))
                    ->where('orders.payment_status', '=', 'paid')
                    ->where(DB::raw('YEAR(orders.created_at)'), '=', $year);
            })
            ->groupBy('months.month')
            ->get();
    }

    public function revenue7Day()
    {
        return $this->model
            ->select(DB::raw('
            dates.date,
            COALESCE(SUM(orders.total),0) as daily_revenue
        '))
            ->from(DB::raw('(
            SELECT CURDATE() - INTERVAL (a.a + (10*b.a) + (100*c.a)) DAY as date
            FROM (
             SELECT 0 AS a UNION ALL
                SELECT 1 UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5 UNION ALL
                SELECT 6 UNION ALL
                SELECT 7 UNION ALL
                SELECT 8 UNION ALL
                SELECT 9
            ) as a
            CROSS JOIN (
                 SELECT 0 AS a UNION ALL
                SELECT 1 UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5 UNION ALL
                SELECT 6 UNION ALL
                SELECT 7 UNION ALL
                SELECT 8 UNION ALL
                SELECT 9
            ) as b
             CROSS JOIN (
                 SELECT 0 AS a UNION ALL
                SELECT 1 UNION ALL
                SELECT 2 UNION ALL
                SELECT 3 UNION ALL
                SELECT 4 UNION ALL
                SELECT 5 UNION ALL
                SELECT 6 UNION ALL
                SELECT 7 UNION ALL
                SELECT 8 UNION ALL
                SELECT 9
            ) as c
        ) as dates'))
            ->leftJoin('orders', function ($join) {
                $join->on(DB::raw('DATE(orders.created_at)'), '=', DB::raw('dates.date'))
                    ->where('orders.payment_status', '=', 'paid');
            })
            ->where(DB::raw('dates.date'), '>=', DB::raw('CURDATE() - INTERVAL 6 DAY'))
            ->groupBy(DB::raw('dates.date'))
            ->orderBy(DB::raw('dates.date'), 'ASC')
            ->get();
    }

    public function revenueCurrentMonth($currentMonth, $currentYear)
    {
        return $this->model->select(
            DB::raw('DAY(created_at) as day'),
            // DB::raw('COALESCE(SUM(JSON_UNQUOTE(JSON_EXTRACT(orders.cart, "$.cartTotal"))),0) as daily_revenue')
            DB::raw('COALESCE(SUM(orders.total),0) as daily_revenue')

        )
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('orders.payment_status', '=', 'paid')
            ->groupBy('day')
            ->orderBy('day')
            ->get()->toArray();
    }

    public function getTotalOrders()
    {
        return $this->model->count();
    }

    public function getCancelOrders()
    {
        return $this->model->where('status', '=', 'cancel')->count();
    }

    private function convertPriceFilter($price)
    {
    }

    private function convertRateFilter($rate)
    {
    }
}
