<?php

namespace App\Http\Controllers;

use App\Http\JsonResponse;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Review::with(['user', 'answers', 'answers.user'])
            ->whereNull('parent_id')
            ->simplePaginate(10);

        return new JsonResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : Response
    {
        $data = $request->json()->all();
        if( !$data ){
            $data = $request->all();
        }

        $validator = Validator::make($data, [
            'review' => 'required',
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('reviews', 'id')->where(function ($table)use($data){
                    return $table->where('id', $data['parent_id'])->whereNull('parent_id');
                })
            ],
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), 400);
        }

        $data = $validator->validated();

        if( isset($data['parent_id']) && !$request->user()->isAdmin() ){
            return new JsonResponse(['Permission denied'], 400);
        }

        $data['user_id'] = $request->user()->id;
        $review = $request->user()->reviews()->create($data);

        if( $review->parent_id ){
            broadcast(new \App\Events\AnswerAdded($review));
        } else {
            broadcast(new \App\Events\ReviewAdded($review));
        }

        return new JsonResponse($review);
    }

    public function storeAnswer(Request $request, int $id) : Response
    {
        if( $request->isJson() ){
            $request->json()->set('parent_id', $id);
        } else {
            $request['parent_id'] = $id;
        }
        return $this->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Review::with(['user', 'answers', 'answers.user'])
            ->find($id);

        return new JsonResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return new JsonResponse(['Action not allowed'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return new JsonResponse(['Action not allowed'], 400);
    }
}
