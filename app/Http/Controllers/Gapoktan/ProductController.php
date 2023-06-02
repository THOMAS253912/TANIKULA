<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\PhotoProduct;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    // set index page view
	public function index() {
		$category = ProductCategory::where('is_active', '=', 1)->get();
		return view('gapoktan.produk.index', compact('category'));
	}

    // handle fetch all eamployees ajax request
	public function fetchAll() {
		$emps = Product::with('photo_product')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    // ->leftJoin('photo_products', function ($join) {
                    //         $join->on('products.id', '=', 'photo_products.product_id');
                    //     })
                    // ->rightJoin('photo_products','photo_products.product_id','=','products.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    // ->select('products.*', 'photo_products.name as photo_product')
                    ->select('products.*', 'product_categories.name as category_product')
                    ->where('product_categories.is_active', '=', 1)
                    ->where('user_id', auth()->user()->id)
                    ->orderBy('products.updated_at', 'desc')
                    ->get();
        $emps = $emps->unique();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Kategori Produk</th>
                <th>Stok</th>
                <th>Berat</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>';
                if ($emp->photo_product->count() > 0) {
                    foreach ($emp->photo_product->take(1) as $photos)
                    if ($photos->name) {
                        $output .= '<img src="../storage/produk/' . $photos->name . '" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                    } else {
                        $output .= '<img src="../stisla/assets/img/example-image.jpg" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                    }
                } else {
                    $output .= '<img src="../stisla/assets/img/example-image.jpg" class="img-fluid img-thumbnail" style="width: 100px; height: 65px; -o-object-fit: cover; object-fit: cover; -o-object-position: center; object-position: center;">';
                }
                $output .= '</td>';
                $output .= '
                <td>' . $emp->name . '</td>';
                if (empty($emp->product_category->name)) {
                    $output .= '<td><a class="text-danger">Tidak ada kategori</a></p>';
                } else {
                    $output .= '<td>' . $emp->product_category->name . '</td>';
                }
                $output .= '<td>' . $emp->stoke . '</td>
                <td>' . $emp->weight . ' gram</td>
                <td>Rp. ' . number_format($emp->price, 0) . '</td>';
                if ($emp->discount) {
                    $output .= '<td>'. $emp->discount . '%</td>';
                } else {
                    $output .= '<td>0%</td>';
                }
                if ($emp->is_active == 1) {
                    $output .= '<td><div class="badge badge-success">Aktif</div></td>';
                } elseif ($emp->is_active == 0) {
                    $output .= '<td><div class="badge badge-danger">Tidak Aktif</div></td>';
                }
                $output .= '<td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 addPhotoProductIcon" data-toggle="modal" data-target="#addPhotoProduct"><i class="bi bi-images h4"></i></a>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 viewPhotoProductIcon" data-toggle="modal" data-target="#viewPhotoProduct"><i class="bi bi-eye h4"></i></a>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Produk!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'category_product_id' => 'required',
            'stoke' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'discount' => 'required',
            'desc' => 'required',
        ], [
            'name.required' => 'Nama produk diperlukan!',
            'name.max' => 'Nama produk maksimal 100 karakter!',
            'category_product_id.required' => 'Kategori produk diperlukan!',
            'stoke.required' => 'Stok produk diperlukan!',
            'price.required' => 'Harga produk diperlukan!',
            'weight.required' => 'Berat produk diperlukan!',
            'discount.required' => 'Diskon produk diperlukan!',
            'desc.required' => 'Deskripsi produk diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_product_id = $request->category_product_id;
            $product->stoke = $request->stoke;
            $product->weight = $request->weight;
            $product->price = $request->price;
            $product->desc = $request->desc;
            // Diskon
            if ($request->discount != 0)
             {
                // Rumus Diskon
                $product->discount = $request->discount;
                $harga_awal = $request->discount/100 * $request->price;
                $harga_akhir = $request->price - $harga_awal;

                // Database
                $product->price_discount = $request->price;
                $product->price = $harga_akhir;
            } else {
                $product->discount = $request->discount;
                $product->price = $request->price;
            }
            $product->is_active = $request->is_active ? 1 : 0;
            $product->code = random_int(1000, 9999);
            $product->user_id = auth()->user()->id;
            $product->save();
            return response()->json([
                    'status' => 200,
                ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Product::join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->leftJoin('photo_products', function ($join) {
                            $join->on('products.id', '=', 'photo_products.product_id');
                        })
                    // ->rightJoin('photo_products','photo_products.product_id','=','products.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'photo_products.name as photo_product')
                    ->with('product_category', 'photo_product')
                    ->find( $id);
		return response()->json($emp);
	}

	// handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'category_product_id' => 'required',
            'stoke' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'discount' => 'required',
            'desc' => 'required',
        ], [
            'name.required' => 'Nama produk diperlukan!',
            'name.max' => 'Nama produk maksimal 100 karakter!',
            'category_product_id.required' => 'Kategori produk diperlukan!',
            'stoke.required' => 'Stok produk diperlukan!',
            'price.required' => 'Harga produk diperlukan!',
            'weight.required' => 'Berat produk diperlukan!',
            'discount.required' => 'Diskon produk diperlukan!',
            'desc.required' => 'Deskripsi produk diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {

            $product = Product::find($request->emp_id);
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->category_product_id = $request->category_product_id;
            $product->weight = $request->weight;
            $product->stoke = $request->stoke;
            $product->desc = $request->desc;

            if ($request->price != $product->price) {
                $product->price = $request->price;
                $product->discount = 0;
                $product->price_discount = null;
            } else {
                // Diskon
                if ($request->discount != 0)
                {
                    if ($product->discount != $request->discount) {
                        // Rumus Diskon
                        if ($product->price_discount != null) {
                            $product->discount = $request->discount;
                            $harga_awal = $request->discount/100 * $product->price_discount;
                            $harga_akhir = $product->price_discount - $harga_awal;

                            // Database
                            $product->price_discount = $product->price_discount;
                            $product->price = $harga_akhir;
                        } elseif ($product->price_discount == null) {
                            // Rumus Diskon
                            $product->discount = $request->discount;
                            $harga_awal = $request->discount/100 * $request->price;
                            $harga_akhir = $request->price - $harga_awal;

                            // Database
                            $product->price_discount = $request->price;
                            $product->price = $harga_akhir;
                        }
                    }
                } elseif ($request->discount == 0) {
                    $product->discount = $request->discount;
                    if ($product->price_discount == 0) {
                        $product->price = $request->price;
                    } else {
                        $product->price = $product->price_discount;
                    }
                    $product->price_discount = null;
                }
            }

            $product->is_active = $request->is_active ? 1 : 0;
            $product->user_id = auth()->user()->id;
            $product->update();
            return response()->json([
                    'status' => 200,
                ]);
        }
	}

    // handle delete an employee ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$emp = Product::where('id', $id)->first();
		$data = PhotoProduct::where('product_id', $id)->get();
		foreach ($data as $key => $value) {
            Storage::delete('produk/' . $value->name);
        }
		PhotoProduct::where('product_id', $id)->delete();
        $emp->delete();
	}

    public function checkSlug(Request $request)
    {
        // Old version: without uniqueness
        $slug = $request->name;

        // New version: to generate unique slugs
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }

    // handle edit an employee ajax request
	public function viewPhoto(Request $request) {
		$id = $request->id;
		$emp = PhotoProduct::distinct()->join('products', 'photo_products.product_id', '=', 'products.id')
                    ->join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('photo_products.*', 'products.id as id_product')
                    ->where('photo_products.product_id', '=', $id)
                    ->get();
		return response()->json($emp);
	}

    // handle delete an employee ajax request
	public function deletePhoto(Request $request) {
        $id = $request->id;
		$emp = PhotoProduct::find($id);
		if (Storage::delete('produk/' . $emp->name)) {
			PhotoProduct::destroy($id);
		} else {
            $emp->delete();
        }
	}

    // handle edit an employee ajax request
	public function addPhoto(Request $request) {
		$id = $request->id;
		$emp = Product::join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->leftJoin('photo_products', function ($join) {
                            $join->on('products.id', '=', 'photo_products.product_id');
                        })
                    // ->rightJoin('photo_products','photo_products.product_id','=','products.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'photo_products.name as photo_product')
                    ->with('product_category', 'photo_product')
                    ->find($id);
		return response()->json($emp);
	}

    // handle update an employee ajax request
	public function addPhotoProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'images' => 'required',
        ], [
            'images.required' => 'Foto produk diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if($request->TotalImages > 0)
            {
                $product = Product::find($request->id);
                $product->name = $request->name;
                $product->update();

                for ($x = 0; $x < $request->TotalImages; $x++)
                {
                    if ($request->hasFile('images'.$x))
                    {
                        $file = $request->file('images'.$x);
                        $fileName = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
                        if ($fileName) {
                            $file->storeAs('produk', $fileName);
                            $insert[$x]['product_id'] = $product->id;
                            $insert[$x]['name'] = $fileName;
                            $insert[$x]['created_at'] = Carbon::now();
                            $insert[$x]['updated_at'] = Carbon::now();
                        }
                    }
                }
                PhotoProduct::insert($insert);
                return response()->json([
                    'status' => 200,
                ]);
            }
            else
            {
            return response()->json([
                    'status' => 401,
                ]);
            }
        }
	}
}
