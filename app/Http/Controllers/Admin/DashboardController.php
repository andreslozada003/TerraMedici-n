<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\{Content,ContactMessage};
class DashboardController extends Controller { public function __invoke(){ return view('admin.dashboard',['services'=>Content::where('type','service')->count(),'projects'=>Content::where('type','project')->count(),'posts'=>Content::where('type','post')->count(),'messages'=>ContactMessage::count(),'latest'=>Content::latest()->take(6)->get()]); } }
