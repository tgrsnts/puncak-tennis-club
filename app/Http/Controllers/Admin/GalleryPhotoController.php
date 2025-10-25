<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryPhotoController extends Controller
{
    public function index() {
        return view('admin.gallery-photo.index');
    }

    public function create() {
        return view('admin.gallery-photo.create');
    }

    public function store() {
        
    }

    public function show() {
        
    }

    public function edit() {
        
    }

    public function update() {
        
    }

    public function destroy() {
        
    }
}
