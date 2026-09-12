<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class SettingController extends Controller {
    public function edit(): View { $settings=StoreSetting::query()->pluck('value','key'); return view('admin.settings.edit',compact('settings')); }
    public function update(Request $request): RedirectResponse {
        $data=$request->validate([
            'store_name'=>['required','string','max:80'],'tagline'=>['required','string','max:140'],'hero_text'=>['nullable','string','max:300'],'logo'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],'remove_logo'=>['nullable','boolean'],
            'whatsapp_number'=>['required','regex:/^[0-9]{8,20}$/'],'whatsapp_opening'=>['required','string','max:500'],'whatsapp_closing'=>['required','string','max:500'],
            'whatsapp_single_template'=>['required','string','max:2000'],'whatsapp_cart_template'=>['required','string','max:4000']
        ]);
        unset($data['logo'],$data['remove_logo']);
        foreach($data as $key=>$value) StoreSetting::put($key,$value);
        if($request->boolean('remove_logo') && !$request->hasFile('logo')) {
            if($old=StoreSetting::valueOf('logo_path')) Storage::disk('public')->delete($old);
            StoreSetting::put('logo_path',null);
        }
        if($request->hasFile('logo')) {
            if($old=StoreSetting::valueOf('logo_path')) Storage::disk('public')->delete($old);
            StoreSetting::put('logo_path',$request->file('logo')->store('branding','public'));
        }
        return back()->with('success','Pengaturan toko berhasil disimpan.');
    }
}
