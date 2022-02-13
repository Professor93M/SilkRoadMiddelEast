<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Images;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Resources\CarouselResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => Rule::in(['asc', 'desc']),
            'field'     => Rule::in(['title', 'state', 'created_at']),
        ]);

        $query = Carousel::query();

        if (request('search')) {
            $query->where('title', 'LIKE', '%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }
        return Inertia::render('Carousel/Index', [
            'carousel' => $query->with('image')->orderBy('created_at','desc')->paginate(20)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction']),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Carousel/Create', [
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $carousel = Carousel::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'state' => $request->state,
        ]);
        $img_url = $request->file('img_url')->store('Carousel', 'public');
        $carousel->image()->save(
            Images::make(['img_url' => $img_url])
        );
        return Redirect::route('carousel.index')->with('success', 'Added Successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function show(Carousel $carousel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function edit($carousel)
    {
        $carousel = new CarouselResources(Carousel::findOrFail($carousel));
        $carousel->image;
        return Inertia::render('Carousel/Edit', [
            'carousels' => $carousel,
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $carousel)
    {
        $carousel = Carousel::findOrFail($carousel);
        if(($request->title !== $carousel->title) || ($request->state !== $carousel->state) || ($request->description !== $carousel->description) || ($request->url !== $carousel->url) || ($request->file('img_url') !== null)){
            if($request->title !== $carousel->title){
                $request->validate([
                    'title' => 'required|min:3',
                ]);
            }
            if($request->description !== $carousel->description){
                $request->validate([
                    'description' => 'nullable|min:10',
                ]);
            }
            if($request->url !== $carousel->url){
                $request->validate([
                    'url' => 'nullable|URL',
                ]);
            }
            $carousel->update([
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'state' => $request->state,
            ]);
            if($request->file('img_url') !== null){
                $request->validate([
                    'img_url' => 'mimes:jpeg,jpg,gif,png|max:2000',
                ]);
                if(Storage::disk('public')->exists($carousel->image->img_url)){
                    Storage::disk('public')->delete($carousel->image->img_url);
                }
                $carousel->image->img_url = $request->file('img_url')->store('carousel', 'public');
                $carousel->image()->update(
                    ['img_url' => $carousel->image->img_url]
                );
            }
            return Redirect::route('carousel.index')->with('success', 'Updated Successfuly');
        }else{
            return Redirect::route('carousel.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function destroy($carousel)
    {
        $carousel = Carousel::findOrFail($carousel);
        if(file_exists(public_path('storage/' . $carousel->image->img_url))){
            unlink(public_path('storage/' . $carousel->image->img_url));
        }
        $carousel->image()->delete();
        $carousel->delete();

        return Redirect::route('carousel.index')->with('success', 'Deleted Successfuly');
    }

    public function carouselDash(){
        if(request('s') === "active"){
            return Inertia::render('Carousel/Selected', [
                'carousel' => Carousel::where('state', '1')->with('image')->orderBy('created_at','desc')->paginate(30),
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
                'title' => 'الاعلانات المفعلة',
            ]);
        }elseif(request('s') === "inactive"){
            return Inertia::render('Carousel/Selected', [
                'carousel' => Carousel::where('state', '0')->with('image')->orderBy('created_at','desc')->paginate(30),
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
                'title' => 'الاعلانات المعلقة',
            ]);
        }else{
            return abort(404);
        }
    }
}
