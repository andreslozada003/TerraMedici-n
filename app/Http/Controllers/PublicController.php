<?php
namespace App\Http\Controllers;
use App\Models\{Content,ContactMessage}; use Illuminate\Http\Request;
class PublicController extends Controller {
 private function list(string $type){ return Content::public()->where('type',$type)->latest('published_at'); }
 public function home(){ return view('public.home',['services'=>$this->list('service')->take(3)->get(),'projects'=>$this->list('project')->take(3)->get(),'posts'=>$this->list('post')->take(3)->get()]); }
 public function services(){ return view('public.list',['items'=>$this->list('service')->paginate(9),'title'=>'Servicios especializados','type'=>'service']); }
 public function service(Content $service){ abort_unless($service->type==='service' && $service->status==='published',404); return view('public.detail',['item'=>$service]); }
 public function projects(){ return view('public.list',['items'=>$this->list('project')->paginate(9),'title'=>'Proyectos realizados','type'=>'project']); }
 public function project(Content $project){ abort_unless($project->type==='project' && $project->status==='published',404); return view('public.detail',['item'=>$project]); }
 public function posts(){ return view('public.list',['items'=>$this->list('post')->paginate(9),'title'=>'Noticias y conocimiento','type'=>'post']); }
 public function post(Content $post){ abort_unless($post->type==='post' && $post->status==='published',404); return view('public.detail',['item'=>$post]); }
 public function about(){ return view('public.about'); } public function contact(){ return view('public.contact'); }
 public function sendContact(Request $r){ $data=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:120','phone'=>'nullable|string|max:30','message'=>'required|string|min:10|max:3000']); ContactMessage::create($data); return back()->with('success','Gracias. Recibimos su solicitud y responderemos pronto.'); }
}
