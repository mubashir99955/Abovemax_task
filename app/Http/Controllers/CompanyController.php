<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('companies.index', compact('companies'));
    }
    public function create()
    {
        return view('companies.create');
    }
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image upload
            'website' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('logo/', $filename);
            $data['logo'] = $filename;
        }

        Company::create($data);
        return redirect()->route('companies.index')
                         ->with('success', 'Company created successfully.');
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image upload
            'website' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('logo/', $filename);
            $data['logo'] = $filename;

            // Delete previous logo if it exists
            if ($company->logo) {
                $previousLogoPath = public_path('logo/' . $company->logo);
                if (file_exists($previousLogoPath)) {
                    unlink($previousLogoPath);
                }
            }
        }

        $company->update($data);
        return redirect()->route('companies.index')
                         ->with('success', 'Company updated successfully');
    }
    public function destroy(Company $company)
    {
        if ($company->logo) {
            $previousLogoPath = public_path('logo/' . $company->logo);
            if (file_exists($previousLogoPath)) {
                unlink($previousLogoPath);
            }
        }
        $company->delete();
        return redirect()->route('companies.index')
                         ->with('success', 'Company deleted successfully');
    }
}
