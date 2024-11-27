<?php

namespace App\Http\Controllers;

use App\Events\NewMessageEvent;
use App\Models\Contact;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 'admin')
        {
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $contacts = Contact::where('viewed',true)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            return view("backend.contact.index",compact('contacts','uvcontacts','books','articles'));
        }
        elseif(Auth::user()->type == 'librarian')
        {
            $categories = Category::where('user_id',Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $contacts = Contact::where('viewed',true)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            return view("backend.contact.index",compact('contacts','uvcontacts','books','articles'));
        }
        else
        {
            return abort(404);
        }

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
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);
        $contact = new Contact();
        $contact->fullname = trim($request->fullname);
        $contact->email = trim($request->email);
        $contact->phone = trim($request->phone);
        $contact->message = \trim($request->message);
        $contact->save();
        $users = User::where('type','<>','client')->get();
        if(\strlen($contact->message) >  30)
        {
            event(new NewMessageEvent($contact->id,ucwords($contact->fullname),$contact->email,ucfirst(substr($contact->message,0,29).'...'),route("contact.show",$contact->id)));
            Notification::send($users,new NewMessageNotification($contact->id,ucwords($contact->fullname),$contact->email,ucfirst(substr($contact->message,0,29).'...'),route('contact.show',$contact->id),'message'));
        }
        else
        {
            event(new NewMessageEvent($contact->id,ucwords($contact->fullname),$contact->email,ucfirst($contact->message),route("contact.show",$contact->id)));
            Notification::send($users,new NewMessageNotification($contact->id,ucwords($contact->fullname),$contact->email,ucfirst($contact->message),route('contact.show',$contact->id),'message'));
        }

        return response()->json(['msg'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        if(Auth::user()->type == 'admin')
        {
            $contact->viewed = true;
            $contact->save();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $contacts = Contact::where('viewed',true)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->get();
            $articles = Article::where('approved','no')->get();
            return view("backend.contact.show",compact('contact','contacts','uvcontacts','articles'));
        }
        elseif(Auth::user()->type == 'librarian')
        {
            $contact->viewed = true;
            $contact->save();
            $categories = Category::where('user_id',Auth::user()->id)->get();
            $id = $categories->pluck('id')->toArray();
            $uvcontacts = Contact::where('viewed',false)->paginate(30)->onEachSide(10);
            $contacts = Contact::where('viewed',true)->paginate(30)->onEachSide(10);
            $books = Book::where('approved','no')->whereIn('category_id',$id)->get();
            $articles = Article::where('approved','no')->whereIn('category_id',$id)->get();
            return view("backend.contact.show",compact('contact','contacts','uvcontacts','articles'));
        }
        else
        {
            return abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return \redirect(route('contact.index'));
    }
}
