<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\DetailInfoProduct;
use App\Models\ProductFilterImage;
use App\Models\IOSeach;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class BasicInfoProduct extends Model
{
    const table_name = 'basic_info_products';
    protected $table = self::table_name;
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const REMOVED_NO = 0;
    const REMOVED_YES = 1;

    protected $fillable = ['title', 'removed', 'status'];

    /*
     *  @param [
     *      'title', 'alias', 'description', 'content',
     *      'warranty_type' => 'Loại bảo hành',
     *      'warranty_period => 'Thời gian bảo hành',
     *      'warranty_policy => 'Chính sách bảo hành',
     *      'dangerous_goods => 'Chất liệu nguy hiểm',
     *      'package_weight' => 'Khối lượng hàng',
     *      'package_dimensions' => 'Kích thước hàng (Dài x Rộng x Cao _cm_)',
     *      '
     * ]
     * */

    const WARRANTY_TYPE = [
        ['id' => 1, 'title' => 'Bằng Phiếu bảo hành và Hóa đơn'],
        ['id' => 2, 'title' => 'Bằng Thẻ bảo hành và Hóa đơn'],
        ['id' => 3, 'title' => 'Bằng Tem bảo hành'],
        ['id' => 4, 'title' => 'Bằng hộp sản phẩm hoặc số Seri'],
        ['id' => 5, 'title' => 'Bằng hóa đơn mua hàng'],
        ['id' => 6, 'title' => 'Bảo hành toàn cầu'],
        ['id' => 7, 'title' => 'Bảo hành điện tử'],
        ['id' => 8, 'title' => 'Bảo hành bởi Nhà sản xuất trong nước'],
        ['id' => 9, 'title' => 'Bảo hành bởi Nhà sản xuất ngoài nước'],
        ['id' => 10, 'title' => 'Bảo hành bởi Nhà cung cấp trong nước'],
        ['id' => 11, 'title' => 'Không bảo hành'],
    ];
    const WARRANTY_PERIOD = [
        ['id' => 1, 'title' => '1 tháng'],
        ['id' => 2, 'title' => '2 tháng'],
        ['id' => 3, 'title' => '3 tháng'],
        ['id' => 4, 'title' => '4 tháng'],
        ['id' => 5, 'title' => '5 tháng'],
        ['id' => 6, 'title' => '6 tháng'],
        ['id' => 7, 'title' => '7 tháng'],
        ['id' => 8, 'title' => '8 tháng'],
        ['id' => 9, 'title' => '9 tháng'],
        ['id' => 10, 'title' => '10 tháng'],
        ['id' => 11, 'title' => '11 tháng'],
        ['id' => 12, 'title' => '12 tháng'],
        ['id' => 15, 'title' => '15 tháng'],
        ['id' => 18, 'title' => '18 tháng'],
        ['id' => 24, 'title' => '2 năm'],
        ['id' => 36, 'title' => '3 năm'],
        ['id' => 48, 'title' => '4 năm'],
        ['id' => 60, 'title' => '5 năm'],
        ['id' => 72, 'title' => '6 năm'],
        ['id' => 84, 'title' => '7 năm'],
        ['id' => 96, 'title' => '8 năm'],
        ['id' => 108, 'title' => '9 năm'],
        ['id' => 120, 'title' => '10 năm'],
        ['id' => 180, 'title' => '15 năm'],
        ['id' => 360, 'title' => '30 năm'],
        ['id' => 'All', 'title' => 'Bảo hành trọn đời'],
    ];
    const DANGEROUS_GOODS = [
        ['title' => 'Liquid', 'id' => 'liquid'],
        ['title' => 'None', 'id' => 'none'],
        ['title' => 'Pin', 'id' => 'battery'],
        ['title' => 'Chất dễ cháy', 'id' => 'flammable'],
    ];

    public function detailInfo(){
        return $this->hasMany(DetailInfoProduct::class, 'basic_pid', 'id');
    }

    public function filters(){
        return $this->hasMany(ProductFilter::class, 'basic_pid', 'id');
    }
    
    public function images(){
        return $this->hasMany(ProductFilterImage::class, 'basic_pid', 'id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'cate_id')->where('type', 1);
    }

    public function getImageUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image, 'product', $size);
    }

    public static function savePrdAfterView($id = 0) {
        $prds_cookie = Cookie::get(BasicInfoProduct::KEY_COOKIE_PRDS_HISTORY, []);
        $prds_cookie = !empty($prds_cookie) ? unserialize($prds_cookie) : [];

        if(count($prds_cookie) > 0 && count($prds_cookie) < 10){
            $prds_cookie = array_splice($prds_cookie, 0, 1);
        }
        $prds_cookie[] = $id;

        $prds_cookie = serialize(array_unique($prds_cookie));
        Cookie ::queue(BasicInfoProduct::KEY_COOKIE_PRDS_HISTORY, $prds_cookie, 60*24*365);
    }

    public static function prdHistory($limit = 8)
    {
        $prds_cookie = Cookie::get(BasicInfoProduct::KEY_COOKIE_PRDS_HISTORY, []);

        $prds_cookie = !empty($prds_cookie) ? unserialize($prds_cookie) : [];

        if(!empty($prds_cookie)) {
            return self::where('status', 2)
                ->whereIn('id',$prds_cookie)
                ->limit($limit)
                ->get();
        }
        return [];
    }

    public static function getRelated($lang = 'vi', $limit = 3, $id){
        //lay toan bo danh sach tag cua tin
        $tags = TagDetail::getTags($id);
        $ids = [];
        foreach($tags as $item){
            $ids[] = $item['tag_id'];
        }
        //lay toan bo tin cung tag
        $news = TagDetail::getNews($ids);
        $ids = [];
        foreach($news as $item){
            if($item['object_id'] != $id && !in_array($item['object_id'], $ids)) {
                $ids[] = $item['object_id'];
            }
        }

        return self::with(['detail', 'category'])
            ->leftJoin('news_detail', 'news_detail.new_id', '=', 'news.id')
            ->select(\DB::raw("COUNT(news_detail.new_id) as rank"), \DB::raw("SUM(news_detail.vote) as vote"), 'news.*')
            ->where([
                ['news.status', '=', 2],
                ['news.published', '>', 0],
                ['news.lang', '=', $lang],
            ])->groupBy('news_detail.new_id')
            ->whereIn('news.id', $ids)
            ->limit($limit)
            ->get();
    }

    static function getRelatedProductByCate($cateId, $proId, $limit = 10) {
        return self::where([
            ['status', self::STATUS_ACTIVE],
            ['id', '!=', $proId],
            ['cate_id', $cateId],
            ['lang', \Lib::getDefaultLang()],
        ])->select('id', 'title', 'alias', 'cate_id', 'image', 'status')->limit($limit)->get();
    }

    public static function maybeInteresting($limit = 4) {
        $wery = self::where('status', 2)
            ->where('lang', \Lib::getDefaultLang())
            ->inRandomOrder()
            ->limit($limit);
        $data = $wery->get();

        if(Empty($data)) {
            self::checkPromoteCampaignPrice(array_keys($data->keyBy('id')->toArray()), $data);
        }

        return $data;
    }


    static function init_product($id = false) {
        $arrtitle = ['Đai bảo vệ đầu gối', 'Đai lưng chống gù', 'Đai bảo vệ gót chân', 'Đai bảo vệ khớp vai', 'Đai bảo vệ khuỷu tay'];
        $title = $arrtitle[rand(0, count($arrtitle) - 1)];
        $title1 = $title.' #'.rand();
        $cate_id = rand(1, 5);
        $basicInfo = [
            'title' => $title1,
            'id' => $id,
            'alias' => str_slug($title1),
            'image' => str_slug($title).'.jpg',
            'embed' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/l5Kh9FUGaug" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'content' => '<ul>
                            <li>Sau chấn thương khớp háng hoặc phẫu thuật cần bắt cóc</li>
                            <li>Phẫu thuật tái tạo vòng bít</li>
                            <li>Trật khớp vai</li>
                            <li>Mâu thuẫn</li>
                        </ul>',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'cate_id' => $cate_id,
            'created' => time()
        ];
        IOSeach::insert([
           'name' => $basicInfo['title'],
           'keyword' => $basicInfo['title'].'-description-'.$basicInfo['description'],
           'table' => 'basic_info_products',
           'alias' => str_slug($basicInfo['title']),
           'cate_id' => $cate_id,
           'created' => time(),
        ]);
        self::insert($basicInfo);
        $sizes = [1, 2, 3, 4];
        $colors = [5, 6, 7, 8];
        $filterId = ProductFilter::insertGetId([
            'basic_pid' => $id,
            'filter_id' => 1,
            'type' => 'size',
        ]);
        
        
        
        $filterId = ProductFilter::insertGetId([
            'basic_pid' => $id,
            'filter_id' => 2,
            'type' => 'size',
        ]);
        
        
        $filterId = ProductFilter::insertGetId([
            'basic_pid' => $id,
            'filter_id' => 6,
            'type' => 'color',
        ]);
        ProductFilterImage::insert([
            'basic_pid' => $id,
            'filter_id' => $filterId,
            'title' => str_slug($title).'.jpg',
            'created' => time()
        ]);
        
        $filterId = ProductFilter::insertGetId([
            'basic_pid' => $id,
            'filter_id' => 7,
            'type' => 'color',
        ]);
        ProductFilterImage::insert([
            'basic_pid' => $id,
            'filter_id' => $filterId,
            'title' => str_slug($title).'.jpg',
            'created' => time()
        ]);
        
        $filterId = ProductFilter::insertGetId([
            'basic_pid' => $id,
            'filter_id' => 8,
            'type' => 'color',
        ]);
        ProductFilterImage::insert([
            'basic_pid' => $id,
            'filter_id' => $filterId,
            'title' => str_slug($title).'.jpg',
            'created' => time()
        ]);
        
        DetailInfoProduct::insert([
            'sku' => uniqid().rand(1, 20),
            'size_id' => 1,
            'color_id' => 6,
            'original_price' => rand(300000, 400000),
            'sale_price' => rand(400000, 700000),
            'quantity' => rand(10, 100),
            'basic_pid' => $id,
            'status' => rand(0, 1),
            'created' => time()
        ]);
        DetailInfoProduct::insert([
            'sku' => uniqid().rand(1, 20),
            'size_id' => 1,
            'color_id' => 8,
            'original_price' => rand(300000, 400000),
            'sale_price' => rand(400000, 700000),
            'quantity' => rand(10, 100),
            'basic_pid' => $id,
            'status' => rand(0, 1),
            'created' => time()
        ]);
        DetailInfoProduct::insert([
            'sku' => uniqid().rand(1, 20),
            'size_id' => 1,
            'color_id' => 7,
            'original_price' => rand(300000, 400000),
            'sale_price' => rand(400000, 700000),
            'quantity' => rand(10, 100),
            'basic_pid' => $id,
            'status' => rand(0, 1),
            'created' => time()
        ]);
        DetailInfoProduct::insert([
            'sku' => uniqid().rand(1, 20),
            'size_id' => 2,
            'color_id' => 6,
            'original_price' => rand(300000, 400000),
            'sale_price' => rand(400000, 700000),
            'quantity' => rand(10, 100),
            'basic_pid' => $id,
            'status' => rand(0, 1),
            'created' => time()
        ]);
        DetailInfoProduct::insert([
            'sku' => uniqid().rand(1, 20),
            'size_id' => 2,
            'color_id' => 8,
            'original_price' => rand(300000, 400000),
            'sale_price' => rand(400000, 700000),
            'quantity' => rand(10, 100),
            'basic_pid' => $id,
            'status' => rand(0, 1),
            'created' => time()
        ]);
        DetailInfoProduct::insert([
            'sku' => uniqid().rand(1, 20),
            'size_id' => 2,
            'color_id' => 7,
            'original_price' => rand(300000, 400000),
            'sale_price' => rand(400000, 700000),
            'quantity' => rand(10, 100),
            'basic_pid' => $id,
            'status' => rand(0, 1),
            'created' => time()
        ]);

        
    }

}

