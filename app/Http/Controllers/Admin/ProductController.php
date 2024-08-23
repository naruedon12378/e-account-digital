<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPostRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\productPrice;
use App\Models\ProductStock;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected FileUploadService $fileUpload;
    protected User $user;

    public function __construct(ProductService $productService, FileUploadService $fileUpload)
    {
        $this->productService = $productService;
        $this->fileUpload = $fileUpload;
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $builder = Product::myCompany()->with('product_category');

            if( !empty($request->search->value) ){

                $search = $request->search->value;
                $builder->where(function($q) use ($search){
                    $q->orWhere('code', $search)
                    ->orWhere('name_th', $search)
                    ->orWhere('name_en', $search)
                    ->orWhere('price', $search)
                    ->orWhere('detail.serial_no', $search)
                    ->orWhere('detail.path_no', $search);

                });
            }
            $data = $builder->get();

            return DataTables::make($data)
                ->addIndexColumn()
                ->addColumn('unit', function ($data) {
                    return $data->unit->name_th;
                })
                ->addColumn('action', function ($data) {
                    return $data->btn_edit . ' ' . $data->btn_delete;
                })
                ->addColumn('isActive', function ($data) {
                    return $data->active_style;
                })
                ->rawColumns(['unit', 'action', 'isActive'])
                ->make(true);
        }

        $tabArr = [
            ['label' => 'All', 'value' => 'all', 'count' => 3, 'class' => 'active', 'color' => 'primary'],
            ['label' => 'Disable', 'value' => 'disable', 'count' => 1, 'color' => 'secondary'],
        ];
        $tabs = statusTabs($tabArr);

        return view('admin.product.index', compact('tabs'));
    }

    public function create()
    {
        $product = new Product();
        $product_images = [];
        $productStocks = [];

        return view('admin.product.create', compact('product', 'product_images', 'productStocks'));
    }

    public function productimport()
    {
        return view('admin.product.product_import');
    }

    public function productexport(Request $request)
    {
        return $this->productService->export($request);
    }

    /**
     * store
     */
    public function store(ProductPostRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'unique:products'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 409);
        }

        if ($request->product_image) {
            $validator = Validator::make(
                $request->all(),
                ['product_image.*' => 'mimes:jpg,jpeg,png,HEIC|max:5120',],
                [
                    'product_image.*.mimes' => trans('file.accept file extension'),
                    'product_image.*.max' => trans('file.Size does not exceed 5 Mb.'),
                ],
            );
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 409);
            }
        }

        $data = $request->except('_token');
        $data['created_by'] = $this->user->firstname;
        $data['company_id'] = 1;
        $product = Product::create($data);

        if( !empty($product->id) ){

            //product detail
            ProductDetail::updateOrCreate([
                'product_id'   => $product->id,
            ],[
                'serial_no'     => @setParamEmptyIsNull($request->serial_no),
                'part_no'     => @setParamEmptyIsNull($request->part_no),
            ]);

            //product price levels
            foreach($request->product_prices as $ri => $product_price){
                productPrice::updateOrCreate([
                    'product_id'   => $product->id,
                    'level'     => $ri+1,
                ],[
                    'price'     => @setParamEmptyIsNull($product_price, 0),
                ]);
            }

            /**
             * set product images
             */
            $this->setImages($product->id, $request->file('product_image'));

            /**
             * set product stock
             */
            $this->setProductStock($product, $data);
        }

        Session::flash('success', 'Created successfully.');
        $redirect = route('products.index');

        return response()->json($redirect);
    }

    /**
     * create product images
     */
    private function setImages($productId, $new_images, $old_request_images = [])
    {
        $old_image = [];
        $old_product_images = ProductImage::where('product_id', $productId)->get();

        // remove unuse image
        if ($old_product_images) {
            foreach ($old_product_images as $key => $product_image) {
                $old_image[] = $product_image->image;

                if (!in_array($old_image[$key], $old_request_images)) {
                    $this->fileUpload->unlink($product_image->image);
                    $product_image->delete();
                }
            }
        }

        // storage image and insert to DB
        if ($new_images) {
            foreach ($new_images as $i => $image) {
                $imageName = null;
                $imageName = $this->fileUpload->save($image, 'product/images', $i);

                $image = [
                    'product_id' => $productId,
                    'image_url' => $imageName,
                    'created_by' => $this->user->firstname,
                    'updated_by' => $this->user->firstname,
                ];
                ProductImage::create($image);
            }
        }
    }

    /**
     * stock
     */
    private function setProductStock(Product $product, $data)
    {
        $stock_ids = isset($data['stock_id']) ? $data['stock_id'] : [];
        $purchaseDates = $data['purchase_date'];
        $purchseQtys = isset($data['purchase_qty']) ? $data['purchase_qty'] : [];
        $purchasePrices = isset($data['price']) ? $data['price'] : [];

        if ($purchaseDates[0]) {
            $old_stock_ids = [];
            $totalQty = 0;

            // remove unuse stock
            $oldProductStocks = ProductStock::where('product_id', $product->id)->get();
            if (count($oldProductStocks) > 0) {
                foreach ($oldProductStocks as $x => $stock) {
                    $old_stock_ids[] = $stock->id;

                    if (!in_array($old_stock_ids[$x], $stock_ids)) {
                        $stock->delete();
                    }
                }
            }

            foreach ($purchaseDates as $key => $value) {
                $_stock['product_id'] = $product->id;
                $_stock['purchase_date'] = $purchaseDates[$key];
                $_stock['qty'] = $purchseQtys[$key];
                $_stock['price'] = $purchasePrices[$key];

                if (in_array($stock_ids[$key], $old_stock_ids)) {
                    $_stock['updated_by'] = $this->user->firstname;
                    ProductStock::where([
                        ['product_id', $product->id],
                        ['id', $stock_ids[$key]]
                    ])->update($_stock);
                } else {
                    $_stock['created_by'] = $this->user->firstname;
                    ProductStock::create($_stock);
                }

                $totalQty += $purchseQtys[$key];
            }
            $product->qty = $totalQty;
            $product->save();
        }
    }

    /**
     * edit
     */
    public function edit($id)
    {
        $product = Product::whereId($id)->with('product_prices')->first();
        $product_images = ProductImage::where('product_id', $id)->get();
        $productStocks = ProductStock::where('product_id', $id)->orderBy('purchase_date', 'desc')->get();
        $product_detail = ProductDetail::where('product_id', $id)->first();

        return view('admin.product.create', compact('product', 'product_images', 'productStocks', 'product_detail'));
    }

    /**
     * update
     */
    public function update(ProductPostRequest $request)
    {
        $data = $request->except('_token', '_method');
        $old_request_images = isset($data['old_image']) ? $data['old_image'] : [];

        // validate product image
        if (count($old_request_images) > 0) {
            $validator = Validator::make(
                $data,
                ['product_image.*' => 'mimes:jpg,jpeg,png,HEIC|max:5120',],
                [
                    'product_image.*.mimes' => trans('file.accept file extension'),
                    'product_image.*.max' => trans('file.Size does not exceed 5 Mb.'),
                ],
            );
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 409);
            }
        } else {
            if ($request->product_image) {
                $validator = Validator::make(
                    $data,
                    ['product_image.*' => 'mimes:jpg,jpeg,png,HEIC|max:5120',],
                    [
                        'product_image.*.mimes' => trans('file.accept file extension'),
                        'product_image.*.max' => trans('file.Size does not exceed 5 Mb.'),
                    ],
                );
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 409);
                }
            }
            // else {
            //     return response()->json(['invalid_image' => __('file.product image is required')], 409);
            // }
        }

        $data['updated_by'] = $this->user->firstname;
        $product = Product::findOrFail($request->id);
        if ($product){
            Product::findOrFail($request->id)->update($data);

            ProductDetail::updateOrCreate([
                'product_id'   => $product->id,
            ],[
                'serial_no'     => @setParamEmptyIsNull($request->serial_no),
                'part_no'     => @setParamEmptyIsNull($request->part_no),
            ]);

            //product price levels
            foreach($request->product_prices as $ri => $product_price){
                productPrice::updateOrCreate([
                    'product_id'   => $product->id,
                    'level'     => $ri+1,
                ],[
                    'price'     => @setParamEmptyIsNull($product_price, 0),
                ]);
            }
        }

        $product->refresh();

        /**
         * set product images
         */
        $this->setImages($product->id, $request->file('product_image'), $old_request_images);

        /**
         * set product stock
         */
        $this->setProductStock($product, $data);

        Session::flash('success', 'Updated successfully');
        $redirect = route('products.index');

        return response()->json($redirect);
    }

    /**
     * permanent delete
     */
    public function destroy($id)
    {
        $status = false;
        $msg = 'ผิดพลาด';

        $product = Product::whereId($id)->first();
        if ($product->delete()) {
            $status = true;
            $msg = 'เสร็จสิ้น';
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }

    /**
     * soft delete
     */
    public function toggleActive($id)
    {
        $status = false;
        $msg = 'บันทึกข้อมูลผิดพลาด';

        $product = Product::find($id);
        if ($product) {
            $product->is_active = !$product->is_active;
            $product->save();

            $status = true;
            $msg = 'บันทึกข้อมูลเรียบร้อย';
        }
        return response()->json(['msg' => $msg, 'status' => $status]);
    }
}
