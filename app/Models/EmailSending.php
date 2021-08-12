<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSending extends Model
{
    //
    protected $fillable = ['to', 'cc', 'bcc', 'subject', 'email_content', 'attachments', 'success', 'failed'];
    protected $dates = ['created_at'];
}
