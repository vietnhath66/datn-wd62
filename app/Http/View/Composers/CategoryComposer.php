<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\ProductCatalogue;

class CategoryComposer
{
    public function compose(View $view)
    {
        $headerCategories = ProductCatalogue::where('publish', 1)
            ->where('parent_id', 0)
            ->with([
                'children' => function ($query) {
                    $query->where('publish', 1)
                        ->with([
                            'children' => function ($query2) {
                                $query2->where('publish', 1)->orderBy('name', 'asc');
                            }
                        ])
                        ->orderBy('name', 'asc');
                }
            ])
            ->orderBy('name', 'asc')
            ->get();

        $view->with('headerCategories', $headerCategories);
    }
}