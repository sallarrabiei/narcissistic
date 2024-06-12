<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

use App\Mail\NotifyMail;


class SendEmailController extends Controller
{

  public function index()
  {
    Mail::to('destination@gmail.com')->send(new NotifyMail());

    return "Great! Your email has been sent successfully.";
  }
}
