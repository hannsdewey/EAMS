<?php

namespace App\Http\Controllers\Staff\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Models\User;
use Mail;

class WorkController extends Controller
{   

    public function FinishWork($id){
        DB::table('works')->where('id',$id)->update(['status'=>1]);
        return redirect('workflow-management');
    }

    public function WorkDetail($id){
        $GetWork = DB::table('works')->where('id',$id)->first();
        $GetWorkDetail= DB::table('work_progress')->where('works',$id)->get();
        

        return view('Staff.Work.WorkDetail',['GetWork'=>$GetWork,'GetWorkDetail'=>$GetWorkDetail]);
    }
    public function ListWork(Request $request){
        $GetWork = DB::table('works')
        ->leftJoin('users','users.id','works.user_id')
        ->leftJoin('user_infomations','user_infomations.id','users.id')
        ->leftJoin('positions','positions.id','user_infomations.positions')
        ->leftJoin('level','level.id','user_infomations.level')
        ->select('user_infomations.full_name','positions.name_position','works.*')
        ->orderBy('works.id', 'DESC')
        ->where('works.user_id',Auth::user()->id)
        ->where('works.deleted',0);
        if(isset($request->keyword)){
            $GetWork=$GetWork
            ->where('users.phone',$request->keyword)
            ->orWhere('user_infomations.full_name',$request->keyword)
            ->where('works.user_id',Auth::user()->id)
            ->where('works.deleted',0)
            ->orWhere('user_infomations.id_number',$request->keyword)
            ->where('works.user_id',Auth::user()->id)
            ->where('works.deleted',0);
        }
        $GetWork=$GetWork->paginate(15);
        return view('Staff.Work.ListWork',
            [
                'GetWork'=>$GetWork,
            ]
        );
    }
    

    

    public function EditWork($id){
        $getWork = DB::table('works')->where('id',$id)->first();
        return view('Staff.Work.EditWork',['getWork'=>$getWork,'id'=>$id]);
    }
    public function PostEditWork($id,Request $request){
        $validate = $request->validate([
            'work_name' => 'required',
            'note' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);
        $getWork = DB::table('works')->where('id',$id)->first();
        $request->user_id=$getWork->user_id;
        if(isset($request->email_notification)){
            $getEmailUser = DB::table('user_infomations')->where('user_id',$request->user_id)->first();

            $getEmailTemplate = DB::table('Staff_mail_template')
            ->where('id','=',2)
            ->first();
            $getEmailConfig = DB::table('Staff_mail_config')
            ->where('id','=',1)
            ->first();
            try{
                $transport = (new \Swift_SmtpTransport($getEmailConfig->mail_host,$getEmailConfig->mail_port))
                ->setUsername($getEmailConfig->mail_username)->setPassword($getEmailConfig->mail_password)->setEncryption($getEmailConfig->mail_encryption);
                $mailer = new \Swift_Mailer($transport);
                $message = (new \Swift_Message($getEmailTemplate->template_title))
                ->setFrom($getEmailConfig->mail_username)
                ->setTo($getEmailUser->email)
                ->addPart(
                  $getEmailTemplate->template_content,
                  'text/html'
              );
                $mailer->send($message);
            }catch (\Swift_TransportException $transportExp){
            }
            DB::table('works')->where('works.id',$id)->update(
                [
                    'work_name'=>$request->work_name,
                    'note'=>$request->note,
                    'from'=>date(strtotime($request->from)),
                    'to'=>date(strtotime($request->to)),
                    'updated_at'=>time(),
                    'updater'=>Auth::user()->id
                ]
            );
            return redirect('Staff/workflow-management');
        }
    }

    public function UpdateProgress($id){
        

        return view('Staff.Work.UpdateProgress',['id'=>$id]);
    }
    public function PostUpdateProgress($id,Request $request){
        $validate = $request->validate([
            'work_progress' => 'required',
        ]);
        DB::table('work_progress')->insert(
            [
                'user_id'=>Auth::user()->id,
                'works'=>$id,
                'content'=>$request->work_progress,
                'created_at'=>time(),
                'created_by'=>Auth::user()->id
            ]
        );
        return redirect('workflow-management/job-details/'.$id);
    }

    public function DeleteWork($id){

        DB::table('works')->where('id',$id)->update(
            [   
                'deleted'=>1,
                'updated_at'=>time(),
                'updater'=>Auth::user()->id,
            ]
        ); 
        return back();

    }
    
}
