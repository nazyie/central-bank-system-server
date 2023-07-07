<?php

namespace App\Http\Controllers;

use App\Common\AuditTrailService;
use App\Models\Member;
use App\Models\RoleActionMapper;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = DB::table('transactions')
            ->selectRaw('transactions.id, member_credit.code AS creditor_member_code, member_deposit.code AS depositor_member_code, transactions.is_credit, transactions.created_at, transactions.amount, transactions.currency')
            ->leftJoin('members AS member_credit', 'member_credit.id', 'transactions.creditor')
            ->leftJoin('members AS member_deposit', 'member_deposit.id', 'transactions.debitor')
            ->where('transactions.debitor', Auth::user()->member_id)
            ->orWhere('transactions.creditor', Auth::user()->member_id)
            ->simplePaginate(10);

        if (Auth::user()->member_id == 1) {
            $transaction = DB::table('transactions')
                ->selectRaw('transactions.id, member_credit.code AS creditor_member_code, member_deposit.code AS depositor_member_code, transactions.is_credit, transactions.created_at, transactions.amount, transactions.currency')
                ->leftJoin('members AS member_credit', 'member_credit.id', 'transactions.creditor')
                ->leftJoin('members AS member_deposit', 'member_deposit.id', 'transactions.debitor')
                ->simplePaginate(10);
        }

        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('transaction.index', [
            'transactions' => $transaction,
            'previousPageUrl' => $transaction->previousPageUrl(),
            'nextPageUrl' => $transaction->nextPageUrl(),
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $creditorMemberCodeList = Member::select('id', 'code')->where('id', Auth::user()->member_id)->get();
        $transactionDirection = [
            [
                'value' => false,
                'description' => 'Outgoing - Debit'
            ]
        ];

        if(Auth::user()->member_id == 1) {
            $creditorMemberCodeList = Member::select('id', 'code')->get();

            $transactionDirection = [
                [
                    'value' => false,
                    'description' => 'Outgoing - Debit'
                ],
                [
                    'value' => true,
                    'description' => 'Incoming - Credit'
                ]
            ];
        }

        $memberCodeList = Member::select('id', 'code')->get();


        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();


        return view('transaction.create-update-page', [
            'viewMode' => 'edit',
            'hasValue' => false,
            'memberCodeList' => $memberCodeList,
            'creditorMemberCodeList' => $creditorMemberCodeList,
            'transactionDirection' => $transactionDirection,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $request->request->add(['created_by' => $userId, 'updated_by' => $userId]);

        $validated = $request->validate([
            'creditor' => 'required',
            'debitor' => 'required',
            'amount' => 'required|numeric',
            'is_credit' => 'required',
            'currency' => 'required',
        ]);

        if (!Auth::user()->member_id == 1  && $request->creditor == 1) {
            abort(401);
        }

        if(!$validated) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $transaction = Transaction::create($request->all());

        AuditTrailService::create('Transaction', 'Create', json_encode($transaction), null, Auth::id(), Auth::user()->member_id);

        return redirect('/transaction');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        $creditorMemberCodeList = Member::select('id', 'code')->where('id', Auth::user()->member_id)->get();
        $transactionDirection = [
            [
                'value' => false,
                'description' => 'Outgoing - Debit'
            ]
        ];

        if(Auth::user()->member_id == 1) {
            $creditorMemberCodeList = Member::select('id', 'code')->get();

            $transactionDirection = [
                [
                    'value' => false,
                    'description' => 'Outgoing - Debit'
                ],
                [
                    'value' => true,
                    'description' => 'Incoming - Credit'
                ]
            ];
        }

        $memberCodeList = Member::select('id', 'code')->get();


        $userProfileInfo = Member::select('members.name AS member_name', 'roles.name as role_name', 'members.code AS member_code')
                        ->leftJoin('roles', 'roles.member_id', 'members.id')
                        ->where('roles.id', Auth::user()->role_id)
                        ->where('members.id', Auth::user()->member_id)
                        ->first();

        return view('transaction.create-update-page', [
            'viewMode' => 'view',
            'hasValue' => true,
            'transaction' => $transaction,
            'memberCodeList' => $memberCodeList,
            'creditorMemberCodeList' => $creditorMemberCodeList,
            'transactionDirection' => $transactionDirection,
            'sideNavItem' => RoleActionMapper::where('role_id', Auth::user()->role_id)->get(),
            'userProfile' => $userProfileInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
