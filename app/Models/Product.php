<?php


namespace App\Models;

class Product extends BaseModel
{
    const table_name = 'products';
    protected $table = self::table_name;
    const KEY = 'product';
    const tableName = 'products';
    const STATUS_NEW = 1;
    public $timestamps = false;
    protected $fillable = ['status', 'removed', 'id', 'alias', 'title'];
   
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Set the post title.
     *
     * @param  string  $value
     * @return string
     */
   
    public function getImageSeoUrl($size = 'original'){
        return \ImageURL::getImageUrl($this->image_seo, 'product', $size);
    }

    public static function getCateNo1()
    {
        return Category::where([['status', 1], ['type', 1], ['pid', 0]])->orderBy('sort', 'ASC')->select('id', 'title', 'pid', 'alias')->get();
    }

    public static function getCateNo2()
    {
        return Category::where([['status', 1], ['type', 1], ['pid', '!=', 0]])->orderBy('sort', 'ASC')->select('id', 'title', 'pid', 'alias')->get();
    }

    public static function getCateNo3($id)
    {
        return Category::where([['status', 1], ['type', 1], ['pid', '!=', 0], ['pid', $id] ])->orderBy('sort', 'ASC')->select('id', 'title', 'pid')->get();
    }

    public function vehicles(){
        return $this->belongsToMany(Vehicles::class, 'products_vehicles', 'p_id', 'v_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    public function status(){
        return $this->hasOne(Status::class, 'tt_id');
    }

    public function TitleStatus($id_tt)
    {
        if(!empty($id_tt))
        {
             return  Status::where('id', $id_tt)->first()->title;
        }
        else
        {
            return '';
        }
    }

    public function accessary(){
        return $this->hasOne(Accessary::class, 'id', 'aces_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function payload(){
        return $this->hasOne(Payload::class, 'id', 'payload_id');
    }

    public function priceProduct(){
        return $this->hasOne(ProductPrice::class, 'id', 'price_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'cate_primary')->select("title","id");
    }

    public function units(){
        return $this->hasOne(Unit::class, 'id', 'unit');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'products_categories', 'p_id', 'cate_id');
    }

    public static function getProductHome()
    {
        return self::where([['status', 1], ['acessery', 0]])->select('title', 'alias', 'id', 'image', 'sale_price', 'original_price', 'status', 'sale', 'new', 'brand_id', 'tt_id')->orderBy('id', 'DESC')->take(10)->get();
    }

    public static function getAllDetailProductWithTitle($cond = [], $order, $basicCond = [], $recperpage = 10) {
        return self::where($cond)->orderByRaw($order)->paginate($recperpage);
    }

    public static function getAllDetailProductWithTitle2($cond = [], $order, $basicCond = [], $recperpage = 10) {
        
        return self::leftJoin('products_vehicles', 'products_vehicles.p_id', '=', 'products.id')->where($cond)->orderByRaw($order)->paginate($recperpage);
    }

    public static function getListProductByListCate($ids = [], $type = 'limit_is_home') {
        $data = self::whereIn('cate_primary', $ids)->where([
            ['status', BaseModel::STATUS_ACTIVE],
            ['removed', BaseModel::REMOVED_NO],
        ])->select('title', 'id', 'sku', 'alias', 'cate_primary', 'image', 'created', 'sale_price', 'original_price', 'unit')->get()->groupBy('cate_primary')->map(function($deal, $k) use ($ids, $type) {
            $cates = Category::whereIn('id', $ids)->select('title', 'id', 'limit_is_sidebar', 'limit_is_home', 'icon')->get()->keyBy('id')->toArray();
            return $deal->take(@$cates[$k][$type]);
        });
        return $data;
    }

    public static function getNamecate($id)
    {
        return Category::where('id', $id)->first();
    }

    

    public static function getListRelatedProductByCateId($id, $currentId, $recperpage = 50) {
        $data = self::where('cate_primary', $id)->where([
            ['status', BaseModel::STATUS_ACTIVE],
            ['removed', BaseModel::REMOVED_NO],
            ['id', '!=', $currentId],
        ])->select('title', 'id', 'sku', 'alias', 'cate_primary', 'image', 'created', 'sale_price', 'original_price')->paginate($recperpage);
        return $data;
    }

    public static function getImageGallery($hotel_id = 0,$type="hotel", $json = false){
        $images = ProductImage::where('type',$type)->where('object_id', $hotel_id)->orderByRaw('sort desc,created desc')->get();
        $data = [];
        foreach($images as $image){
            $tmp = $image->toArray();
            $tmp['img'] = $image->image;
            $tmp['image_sm'] = $image->getImageUrl('medium');
            $tmp['image_md'] = $image->getImageUrl('medium');
            $tmp['image'] = $image->getImageUrl('large');
            $tmp['image_org'] = $image->getImageUrl();
            array_push($data, $tmp);
        }
        return $json ? json_encode($data) : $data;
    }

    public static function getAllProductByCate($cat_id, $pagi = 10,$search=''){
        if($cat_id > 0) {
            $data = self::leftJoin('products_categories', 'products_categories.p_id', '=', 'products.id')
                ->leftJoin('categories', 'categories.id', '=', 'products_categories.cate_id')
                ->where([
                    ['categories.status', BaseModel::STATUS_ACTIVE],
                    ['categories.id', $cat_id]
                ]);
            if($search != '') {
                $data =$data->where('products.title','LIKE','%'.$search.'%');
            }
            $data = $data->select('products.tt_id', 'products.sale', 'products.sale_price','products.id', 'products.title', 'products.image', 'products.alias', 'products.sale_price', 'products.original_price', 'products.sku', 'products.quantity', 'products.created','products.description')
                ->where([
                    ['products.status', BaseModel::STATUS_ACTIVE],
                    ['products.created', '>', '0'],
                ]);
            $data = $data->orderBy('products.created', 'desc')
                ->paginate($pagi);
            return $data;
        }else{
            $data = self::select('products.tt_id', 'products.sale', 'products.sale_price','products.id', 'products.title', 'products.image', 'products.alias', 'products.sale_price', 'products.original_price', 'products.sku', 'products.quantity', 'products.created','products.description')
                ->where([
                    ['products.status', BaseModel::STATUS_ACTIVE],
                    ['products.created', '>', '0'],
                ]);
            if($search != '') {
                $data =$data->where('products.title','LIKE','%'.$search.'%');
            }
            $data = $data->orderBy('products.created', 'desc')
                ->paginate($pagi);
            return $data;
        }
    }

}