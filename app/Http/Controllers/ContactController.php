<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\SendAddListContact;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactCollection;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = auth()->user()->contacts()->create($request->all());

        Mail::to($contact->email)->send(new SendAddListContact($contact));

        return response()->json([
            'success'       => true,
            'message'       => __('Contact added successfully'),
        ], Response::HTTP_CREATED);
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

        $contact->update($request->all());

        return response()->json([
            'success'       => true,
            'message'       => __('Contact successfully updated'),
        ], Response::HTTP_OK);
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

        return response()->json([
            'success'       => true,
            'message'       => __('Contact successfully removed'),
        ], Response::HTTP_OK);
    }

    public function listContacts()
    {
        $contacts = Contact::where('user_id', auth()->user()->id)->latest()->paginate(10);

        return response()->json([
            'success'       => true,
            'data'          => new ContactCollection($contacts),
            'pagination'    => [
                                'total'         => $contacts->total(),
                                'current_page'  => $contacts->currentPage(),
                                'per_page'      => $contacts->perPage(),
                                'last_page'     => $contacts->lastPage(),
                                'from'          => $contacts->firstItem(),
                                'to'            => $contacts->lastItem(),
                            ],
            'message'       => __('Contacts List'),
        ], Response::HTTP_OK); 
    }

    public function search(Request $request)
    {
        $contacts = Contact::where('user_id', auth()->user()->id)
                           ->name($request->get('search'))
                           ->email($request->get('search'))
                           ->latest()
                           ->paginate(10);

        return response()->json([
            'success'       => true,
            'data'          => new ContactCollection($contacts),
            'pagination'    => [
                                'total'         => $contacts->total(),
                                'current_page'  => $contacts->currentPage(),
                                'per_page'      => $contacts->perPage(),
                                'last_page'     => $contacts->lastPage(),
                                'from'          => $contacts->firstItem(),
                                'to'            => $contacts->lastItem(),
                            ],
            'message'       => __('Contacts filter'),
        ], Response::HTTP_OK); 
    }
}
