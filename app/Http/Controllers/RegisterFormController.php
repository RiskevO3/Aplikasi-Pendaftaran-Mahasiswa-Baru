<?php

namespace App\Http\Controllers;

use App\Models\RegisterForm;
use App\Models\ProvinceAndCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterFormController extends Controller
{
    /**
     * Store a newly created RegisterForm in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'ktp_address' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'province_name' => 'required|string|max:255',
            'city_name' => 'required|string|max:255',
            'telephone_number' => 'required|string|max:16',
            'phone_number' => 'required|string|max:16|starts_with:08',
            'email' => 'required|string|email|max:255|unique:register_forms',
            'citizenship' => 'required|in:WNI Asli,WNI Keturunan,WNA',
            'citizen_origin' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'birth_provinces' => 'required|string|max:255',
            'birth_cities' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'marriage_status' => 'required|in:N,Y,O',
            'religion' => 'required|in:Islam,Kristen Protestan,Kristen Katolik,Kristen Ortodoks,Katolok,Hindu,Budha,Khong Hu Ciu',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $provinceAndCity = ProvinceAndCity::where('province_name', $request->province_name)
            ->where('city_name', $request->city_name)
            ->first();

        if (!$provinceAndCity) {
            return redirect()->back()->withErrors([
                'province' => 'Province not found',
                'city' => 'City not found',
            ])->withInput();
        }

        RegisterForm::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'ktp_address' => $request->ktp_address,
            'current_address' => $request->current_address,
            'kecamatan' => $request->kecamatan,
            'provinces_and_cities_id' => $provinceAndCity->id,
            'telephone_number' => $request->telephone_number,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'citizenship' => $request->citizenship,
            'citizen_origin' => $request->citizen_origin,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'birth_provinces' => $request->birth_provinces,
            'birth_cities' => $request->birth_cities,
            'gender' => $request->gender,
            'marriage_status' => $request->marriage_status,
            'religion' => $request->religion,
        ]);
        session()->flash('success', 'Sukses!, harap menunggu admin untuk memproses registrasi anda!');
        return redirect()->route('dashboard');
    }
}