<?php

namespace App\Http\Controllers;

use App\Org;
use Illuminate\Http\Request;

class OrgController extends Controller
{
    public function getOrgIdFromName(Request $request){
        $inData = $request->all();
        $orgName = $inData['orgName'];
        $thisOrg = new Org();
        try {
            $thisOrgId = $thisOrg->getOrgId($orgName);
            return response()->json([
                'orgId'=>$thisOrgId,
                'result'=>'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result'=>'error',
                'errorDescription'=>$e>getMessage()
            ]);
        }
    }
    public function getOrgHomeFromName(Request $request){
        $inData = $request->all();
        $orgName = $inData['orgName'];
        $thisOrg = new Org();
        try {
            $thisOrgHome = $thisOrg->getOrgHome($orgName);

            return response()->json([
                'orgHome'=>$thisOrgHome,
                'result'=>'ok'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result'=>'error',
                'errorDescription'=>$e>getMessage()
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function show(Org $org)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function edit(Org $org)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Org $org)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Org  $org
     * @return \Illuminate\Http\Response
     */
    public function destroy(Org $org)
    {
        //
    }
}
