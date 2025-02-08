<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendEmailCampaignNow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        Log::info('SendEmailCampaignNow job started.');

        $getMailSend = DB::table('admin_mail_campaign_detail')->where('receipt_status', 0)->get();
        $getEmailConfig = DB::table('admin_mail_config')->where('id', 1)->first();

        foreach ($getMailSend as $items) {
            $getEmailTemplate = DB::table('admin_mail_template')
                ->where('id', '=', $items->admin_template_id)
                ->first();
            try {
                Log::info('Preparing to send email to: ' . $items->user_email);

                $transport = (new \Swift_SmtpTransport($getEmailConfig->mail_host, $getEmailConfig->mail_port))
                    ->setUsername($getEmailConfig->mail_username)
                    ->setPassword($getEmailConfig->mail_password)
                    ->setEncryption($getEmailConfig->mail_encryption);
                $mailer = new \Swift_Mailer($transport);

                $message = (new \Swift_Message($getEmailTemplate->template_title))
                    ->setFrom([$getEmailConfig->mail_username => $getEmailConfig->mail_from_name])
                    ->setTo($items->user_email)
                    ->addPart($getEmailTemplate->template_content, 'text/html');

                $result = $mailer->send($message);

                if ($result) {
                    Log::info('Email sent successfully to: ' . $items->user_email);
                    DB::table('admin_mail_campaign_detail')->where('id', $items->id)->update([
                        'receipt_status' => 1,
                        'receipt_time' => strtotime('now'),
                    ]);
                } else {
                    Log::error('Email sending failed for user: ' . $items->user_email);
                    DB::table('admin_mail_campaign_detail')->where('id', $items->id)->update([
                        'receipt_status' => 2,
                        'receipt_time' => strtotime('now'),
                    ]);
                }
            } catch (\Swift_TransportException $transportExp) {
                Log::error('Email sending failed for user: ' . $items->user_email, [
                    'error' => $transportExp->getMessage(),
                ]);

                DB::table('admin_mail_campaign_detail')->where('id', $items->id)->update([
                    'receipt_status' => 2,
                    'receipt_time' => strtotime('now'),
                ]);
            } catch (\Exception $e) {
                Log::error('An unexpected error occurred for user: ' . $items->user_email, [
                    'error' => $e->getMessage(),
                ]);

                DB::table('admin_mail_campaign_detail')->where('id', $items->id)->update([
                    'receipt_status' => 2,
                    'receipt_time' => strtotime('now'),
                ]);
            }
        }

        Log::info('SendEmailCampaignNow job finished.');
    }
}
