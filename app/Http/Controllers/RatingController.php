<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Rating;
use App\RatingToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function index()
    {
        $ratings = Rating::orderBy('id', 'DESC')->paginate(9);
        return view('ratings.index', compact('ratings'));
    }

    public function create(Request $request)
    {
        $rt = RatingToken::where('token', $request->get('token'))->firstOrFail();
        return view('ratings.create', ['token'=>$rt->token]);
    }

    public function store(RatingRequest $request)
    {
        $data = $request->all();
        $rt = RatingToken::where('token', $data['token'])->firstOrFail();
        Rating::create([
            'name'=>$data['name'],
            'stars'=>$data['stars'],
            'review'=>$data['review']
        ]);
        $rt->delete();
        flash('Sua avaliação foi publicada!')->success();
        return redirect()->route('index');
    }
}
