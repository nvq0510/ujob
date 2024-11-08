<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function showByPostalCode(Request $request)
    {
        // Lấy tham số từ route hoặc query và đảm bảo là chuỗi
        $postal_code = (string) $request->route('postal_code'); 
        // Hoặc nếu tham số là query param:
        // $postal_code = (string) $request->query('postal_code');

        $address = Address::where('postal_code', $postal_code)
                          ->select('region_kanji', 'city_kanji', 'area_kanji')
                          ->first();

        if ($address) {
            return response()->json($address, 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy địa chỉ với mã bưu điện này'], 404);
        }
    }
}
