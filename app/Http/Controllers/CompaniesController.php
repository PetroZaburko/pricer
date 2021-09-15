<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $companies = Company::paginate(config('view.per_page'));
        return view('pages.companies',['companies' => $companies]);
    }


    public function company($id) {
        $company = Company::find($id);
        return response()->json([
            'company' => $company
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'unique:companies'
            ]
        ]);
        $company = Company::create($request->all());
        return response()->json([
            'name' => $company->name,
            'id' => $company->id,
            'base_uri' => $company->base_uri
        ]);
    }



    public function status($id) {
        $company = Company::find($id);
        $company->toggleStatus(!$company->status);
        $company->users()->update(['status' => $company->status]);

        return response()->json([
            'message' => "Company $company->name ". $company->getCompanyStatus(),
            'status' => $company->status
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $this->validate($request, [
            'name' => [
                'required', Rule::unique('companies')->ignore($company->id)
                ]
        ]);
        $company->update($request->all());

        return response()->json([
            'name' => $company->name,
            'base_uri' => $company->base_uri,
            'status' => $company->wasChanged()
        ]);
    }

}
