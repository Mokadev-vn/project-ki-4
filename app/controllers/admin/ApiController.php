<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Categories;

class ApiController extends Controller
{
    public function chart(){
        $categories = new Categories();
        $listCates = $categories->params(['p.name', 'count(pd.id) as total'])->join('products pd', 'p.id = pd.product_type_id')->where('p.show_index', 1)->groupBy('p.id')->get();
        echo json_encode($listCates);
    }
}