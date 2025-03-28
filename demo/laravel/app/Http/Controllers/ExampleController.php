<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExampleController extends Controller
{
    /**
     * Form validation example
     */
    public function formExample()
    {
        return view('examples.form');
    }

    /**
     * Process form submission
     */
    public function processForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:50',
            'email' => 'required|email',
            'subject' => 'required|min:5',
            'message' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            flash()->error('Please fix the errors in the form!');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Success scenario
        flash()
            ->success('Your message has been sent successfully!')
            ->option('timeout', 8000);

        return redirect()->route('form.example');
    }

    /**
     * AJAX example page
     */
    public function ajaxExample()
    {
        return view('examples.ajax');
    }

    /**
     * Process AJAX request
     */
    public function processAjax(Request $request)
    {
        $action = $request->input('action');
        $success = rand(0, 10) > 3; // 70% success rate

        if ($success) {
            flash()->success("The $action action was completed successfully!");
            return response()->json(['status' => 'success']);
        } else {
            flash()->error("The $action action failed. Please try again.");
            return response()->json(['status' => 'error'], 422);
        }
    }

    /**
     * Demonstrate different notification positions
     */
    public function positionsExample()
    {
        return view('examples.positions');
    }

    /**
     * Show notification at specified position
     */
    public function showAtPosition(Request $request)
    {
        $position = $request->input('position', 'top-right');

        flash()
            ->option('position', $position)
            ->info("This notification appears at the '$position' position!");

        return redirect()->route('positions.example');
    }

    /**
     * Interactive playground to test notification options
     */
    public function playground()
    {
        return view('examples.playground');
    }
}
