<?php

namespace App\Http\Controllers;

use App\Models\ProvinceAndCity;
use App\Models\RegisterForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterListController extends Controller
{
    public function index()
    {
        $list_registers = RegisterForm::select('id', 'full_name', 'phone_number', 'email', 'citizenship', 'created_at', 'updated_at')->get();
        return view('admin.list-register', compact('list_registers'));
    }
    public function edit($id)
    {
        $register = RegisterForm::find($id);
        return view('admin.edit-register', compact('register'));
    }

    public function delete($id)
    {
        $register = RegisterForm::findOrFail($id);
        $register->delete();
        session()->flash('success', 'Data berhasil dihapus');
        return redirect()->route('admin.list-register');
    }

    public function update(Request $request,$id)
    {
        $register = RegisterForm::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'ktp_address' => 'required|string|max:255',
            'current_address' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'province_name' => 'required|string|max:255',
            'city_name' => 'required|string|max:255',
            'telephone_number' => 'required|string|max:16',
            'phone_number' => 'required|string|max:16|starts_with:08',
            'email' => ['required','string','email','max:255',Rule::unique(RegisterForm::class)->ignore($register->id)],
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

        $register->update([
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
        $register->save();
        session()->flash('success', 'Sukses!, harap menunggu admin untuk memproses registrasi anda!');
        return redirect()->route('dashboard');
    }
}