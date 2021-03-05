<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BasicInfoProduct;
use App\Models\ProductFilterImage;
use App\Models\Category;
use App\Models\ColorSize;
use App\Models\IOSeach;
use App\Models\Fabric;
use App\Models\ProductFilter;
use App\Models\Order;
use App\Models\Timeline;
use App\Models\OrderItems;
use App\Models\DetailInfoProduct;
use App\Models\DetailProductImages;

class _Dev extends Controller
{
    public function index($action = '')
    {
        $action = str_replace('-', '_', $action);
        if (method_exists($this, $action)) {
            return $this->$action();
        }
    }

    function __init__products()
    {
        if (isset($_GET['__init__products'])) {
            BasicInfoProduct::truncate();
            DetailInfoProduct::truncate();
            ProductFilter::truncate();
            ProductFilterImage::truncate();
            IOSeach::truncate();
            for($i = 1; $i <= 50; $i++) {
                BasicInfoProduct::init_product($i);
            }
            die(__FILE__ . __LINE__);
        }
        die(__FILE__ . __LINE__);
    }
    
    function __init_fabric()
    {
        if (isset($_GET['__init_fabric'])) {
            Fabric::truncate();
            for($i = 1; $i <= 10; $i++) {
                Fabric::__init_fabric($i);
            }
            die(__FILE__ . __LINE__);
        }
        die(__FILE__ . __LINE__);
    }

    function __init__timeline()
    {
        if (isset($_GET['__init__timeline'])) {
            Timeline::truncate();
            for($i = 1; $i <= 5; $i++) {
                Timeline::__init__timeline($i);
            }
            die(__FILE__ . __LINE__);
        }
        die(__FILE__ . __LINE__);
    }
    
    function __init__category()
    {
        if (isset($_GET['__init__category'])) {
            for($i = 1; $i <= 5; $i++) {
                Category::init_category($i);
            }
            die(__FILE__ . __LINE__);
        }
        die(__FILE__ . __LINE__);
    }
    
    function __init__order()
    {
        if (isset($_GET['__init__order'])) {
            Order::truncate();
            OrderItems::truncate();
            for($i = 1; $i <= 40; $i++) {
                Order::init_order($i);
            }
            die(__FILE__ . __LINE__);
        }
        die(__FILE__ . __LINE__);
    }
}
