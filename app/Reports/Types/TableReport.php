<?php

namespace App\Reports\Types;

use App\Reports\Contracts\ReportInterface;

class TableReport implements ReportInterface
{
    public function name(): string
    {
        return "Table Report";
    }

    public function type(): string
    {
        return "table";
    }

    // public function generate($query): array
    // {
    //     return $query->limit(50)->get()->toArray();
    // }

    public function generate($query): array
    {
        $table = $query->getModel()->getTable();

        $columns = [

            'users' => ['id','name','email','phone','gender','nationality','user_role','approval','created_at'],

            'assignments' => ['id','title','task_type','status','assigned_to','created_by','due_date','price','created_at'],

            'campaigns' => ['id','type','status','created_by','created_at'],

            'campaign_check_emails' => ['id','name','email','domain','is_valid','disposable','dns','created_at'],

            'campaign_recipients' => ['id','campaign_id','status','created_at'],

            'donations' => ['id','name','email','phone','amount','purpose','receipt_number','created_at'],

            'enquiries' => ['id','name','email','phone','role','message','created_at'],

            'incentives' => ['id','title','amount','status','reason','created_at'],

            'invoices' => ['id','invoice_number','subtotal','tax','discount','total','payment_status','status','issue_date'],

            'payments' => ['id','amount','status','payment_method','currency','transaction_id','created_at'],

            'receipts' => ['id','receipt_number','subtotal','tax','discount','total','payment_status','issue_date'],

            'referrals' => ['id','referrer_id','referred_id','step','created_at'],

            'rewards' => ['id','title','amount','status','reason','receipt_no','entitlement','appraisal','created_at']
        ];

        $selectColumns = $columns[$table] ?? ['id','created_at'];

        return $query->select($selectColumns)->limit(50)->get()->toArray();
    }
}