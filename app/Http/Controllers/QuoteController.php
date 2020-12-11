<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    public function add_quote(Request $request)
    {
        if ($request->isMethod("POST")) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'text' => 'required|string|max:1000',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $quote = new Quote();
                $quote->user_id = auth()->id();
                $quote->text = $data['text'];
                if ($quote->save()) {
                    $status = '<div class="bg-teal-200 relative text-teal-600 py-3 px-3 rounded-lg" 
                        >Quote added successfully.</div>';
                    return redirect()->route('dashboard')->with('status', $status);
                }
                $status = '<div class="bg-red-200 relative text-red-600 py-3 px-3 rounded-lg" 
                        >Quote added failed.</div>';
                return redirect()->back()->withInput()->with('status', $status);
            } catch (QueryException $e) {
                $status = '<div class="bg-red-200 relative text-red-600 py-3 px-3 rounded-lg" 
                        >Something Went wrong.</div>';
                return redirect()->back()->withInput()->with('status', $status);
            }
        }
        return view('dashboard');
    }

    public function edit_quote(Request $request)
    {
        if ($request->isMethod("POST")) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'id' => 'required|numeric',
                'text' => 'required|string|max:1000',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $quote = Quote::find($data['id']);
            if (isset($quote) && $quote->user_id === auth()->id()) {
                try {
                    if ($quote->update(['text'=> $data['text']])) {
                        $status = '<div class="bg-teal-200 relative text-teal-600 py-3 px-3 rounded-lg" 
                        >Quote update successful.</div>';
                        return redirect()->route('dashboard')->with('status', $status);
                    }
                    $status = '<div class="bg-red-200 relative text-red-600 py-3 px-3 rounded-lg" 
                        >Quote update failed.</div>';
                    return redirect()->back()->withInput()->with('status', $status);
                } catch
                (QueryException $e) {
                    $status = '<div class="bg-red-200 relative text-red-600 py-3 px-3 rounded-lg" 
                        >Something Went wrong.</div>';
                    return redirect()->back()->withInput()->with('status', $status);
                }
            } else {
                $status = '<div class="bg-red-200 relative text-red-600 py-3 px-3 rounded-lg" 
                        >Quote not found.</div>';
                return redirect()->back()->withInput()->with('status', $status);
            }
        }
    }

    public function delete_quote(Request $request)
    {
        if ($request->isMethod('DELETE')) {
            $id = $request->post('id');
            $quotte = Quote::find($id);
            if ($quotte->delete()) {
                return 'success';
            }
        }
    }
}
