<?php

namespace App;

class Feedback extends \Eloquent {
    public static function rules($id = 0) {
        return [
            "fullname"  => "required|max:100",
            "email"     => "required|email|max:100",
            'phone'     => 'max:11|regex:/[0]\d{9,11}$/',
            'content'   => 'required|max:1024',
        ];
    }

	protected $fillable = ['fullname', 'status', 'email', 'phone', 'content'];
}