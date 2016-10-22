<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new Category();
        $this->url_pattern = "contact";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $input = $this->form_input;
        if(!$input){
            $input = array();
            $input["keyword"] = "";
        }

        $this->data = array();
        $this->data['model'] = new Contact();

        return view($this->url_pattern, ['data'=>$this->data, 'model'=>$this->data['model']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
http://php.net/manual/en/function.mail.php

// mail UTF-8
$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
     */
    public function store(Request $request)
    {
        $from       = $request->input("email");
        $from_name  = $request->input("name");
        $from_text  = $from_name . ' <' . $from . '>';

        $to         = env('MAIL_ADMIN');
        $to_name    = env('MAIL_ADMIN_NAME');
        $to_text    = $to_name . ' <' . $to . '>';

        $subject    = "[" . env('APP_NAME') . "]Contact email from " . $from;
        $message    = $request->input('message');

        $headers    = array();
        $headers[]  = "MIME-Version: 1.0";
        $headers[]  = "Content-type: text/plain; charset=UTP-8";
        $headers[]  = 'From: ' . $from_text;
        $headers[]  = 'Reply-To: ' . $from_text;
        $headers[]  = 'X-Mailer: PHP/' . phpversion();
        $headers_s  = implode("\r\n", $headers);

        $addition   = env('MAIL_ADMIN');

        mail($to_text, $subject, $message, $headers_s, $addition);

        // return redirect($this->url_pattern . '_finish');
        return redirect('lien-lac-hoan-tat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
