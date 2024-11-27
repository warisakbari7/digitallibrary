<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'english' => 'required|unique:tags,ename',
            'dari' => 'required|unique:tags,dname',
            'pashto' => 'required|unique:tags,pname',
        ]);
        
        if($validator->fails())
        {
            return \response()->json(['status' => 0,'error' => $validator->errors()]);
        }
        else
        {
            $tag = new Tag();
            $tag->ename = trim($request->english);
            $tag->dname = trim($request->dari);
            $tag->pname = trim($request->pashto);
            $tag->save();
            $tag = Tag::find(Tag::max('id'));
            return \response()->json(['status' => 1,'tag' => $tag]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $tag = Tag::find($request->id);
        return \response()->json($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Tag $tag)
    {
        $validator = Validator::make($request->all(),[
            "english" => "required",
            "dari" => "required",
            "pashto" => "required",
        ]);
        if($validator->fails())
        {
            return \response()->json(['status' => 0,'errors' => $validator->errors()]);
        }
        else
        {
            $ta = Tag::find($request->id);
            $ta->ename = trim($request->english);
            $ta->dname = trim($request->dari);
            $ta->pname = trim($request->pashto);
            $ta->save();
            return \response()->json(['status' => 1,'tag' => $ta]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return \response()->json(['status' => 1,'tag' => $tag]);
    }

    public function loadmore(Request $request)
    {
        $data = '';
        $last_id = '';
        $button = '';
        $tags = Tag::where('id', '<', $request->id)->orderBy('id','desc')->limit(15)->get();
        if(count($tags) > 0 )
        {


            foreach ($tags as $tag) {
                $data .= '<tr id="tag'.$tag->id .'">'.
                '<td></td>'.
                '<td>'. $tag->ename .'</td>'.
                '<td><a href="javascript:void(0)"><i onclick="Show(this)" data-id=" '. $tag->id .'" data-type="tag" class="fa fa-edit text-dark"></i></a></td> 
                '. '<td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="'. $tag->id .'" data-type="catagory" class="fa fa-trash"></i></a></td>' .'</tr>';
                $last_id = $tag->id;
            }
            $button = "<button data-type='moretag' data-id=' $last_id ' id='btn_loadmore_tag' onclick='loadmore(this)' class='btn btn-primary w-100'>Load More</button>";
            return \response()->json(['button'=>$button,'rows'=>$data, 'type'=>'tag']);


        }
        else
        {
            
            $button = '<button class="btn btn-warning w-100">No Data Found</button>';
            return \response()->json(['button'=>$button,'rows'=>$data,'type' => 'tag']);
        }
    }

    public function search(Request $request)
    {
        $data = '';
        $button = '';
        $tags = Tag::where('ename', 'like', '%'.trim($request->name).'%')->orWhere('dname', 'like', '%'.trim($request->name).'%')->orWhere('pname', 'like', '%'.trim($request->name).'%')->get();
        if(count($tags) > 0 )
        {


            foreach ($tags as $tag) {
                $data .= '<tr id="tag'.$tag->id .'">'.
                '<td></td>'.
                '<td>'. $tag->name .'</td>'.
                '<td>'. $tag->dname .'</td>'.
                '<td>'. $tag->pname .'</td>'.
                '<td><a href="javascript:void(0)"><i onclick="Show(this)" data-id=" '. $tag->id .'" data-type="tag" class="fa fa-edit text-dark"></i></a></td> 
                '. '<td><a href="javascript:void(0)" class="text-dark"><i onclick="ShowModal(this)" data-id="'. $tag->id .'" data-type="tag" class="fa fa-trash"></i></a></td>' .'</tr>';
            }
            return \response()->json(['rows'=>$data, 'type'=>'tag']);
        }
        else
        {
            $data = '<tr>
            <td></td>
            <td>No Match</td>
            </tr>';
            return \response()->json(['button'=>$button,'rows'=>$data,'type' => 'tag']);
        }
    }
}
