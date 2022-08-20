<?php

namespace App\Http\Controllers;

use App\Models\UserUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserUrlController extends Controller
{
    public function redirectWebsiteByLink($short_url){
        $url = UserUrl::query()->where('short_url',env("APP_URL").$short_url)->first();
        if (!empty($url)){
            $url->hit_count = $url->hit_count + 1;
            $url->save();
            return redirect()->away($url->url);
        }else{
            return view('frontend.url.not_found');
        }

    }

    public function store(Request $request){

        list($rules, $customMessages) = $this->validationRulesAndMessages();

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $url = new UserUrl();
        $url->url = $request->user_url;
        $url->short_url = env("APP_URL").substr(md5(mt_rand()), 0, 8);
        $url->hit_count = 0;
        $url->save();

        return view('frontend.url.generated_url',compact('url'));
    }

    public function update(Request $request ,$id){

        list($rules, $customMessages) = $this->validationRulesAndMessages();

        $error = Validator::make($request->all(), $rules, $customMessages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $check = UserUrl::where('short_url',$request->user_url)->first();
        if (!empty($check)){
            return response()->json(['errors' => ['This URL has already been taken']], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $url = UserUrl::findOrFail($id);
        $url->short_url = $request->user_url;
        $url->hit_count = 0;
        $url->save();

        return view('frontend.url.generated_url',compact('url'));

    }

    private function validationRulesAndMessages()
    {
        $rules = [
            'user_url' => ['required','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            //'user_url' => 'required',
        ];

        $customMessages = [
            'user_url.required' => 'Please provide your URL',
            'user_url.regex' => 'The  URL format is invalid.',
        ];


        return [$rules, $customMessages];
    }

    public function clickCountByLink(Request $request){

        $checkUrl = UserUrl::query()->where('short_url',$request->shareUrl)->first();

        if (!empty($checkUrl)){
            return view('frontend.url.click_count',compact('checkUrl'));
        }

       return '<h4 class="text-danger">Invalid URL</h4>';
    }

}
