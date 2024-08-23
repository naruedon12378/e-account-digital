<?php

namespace App\Services;

use App\Exports\ProductExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Interface\ProductInterface;

class ProductService
{
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->product->update($data, $id);
    }

    public function delete($id)
    {
        return $this->product->delete($id);
    }

    public function all()
    {
        return $this->product->all();
    }

    public function export(Request $request)
    {
        $param = $request->all();
        $date = "_ALL";
        $filename = "Product_Export";
        return Excel::download(new ProductExport($param), $filename . $date . '.xlsx');
    }

    public function find($id)
    {
        return $this->product->find($id);
    }
}
