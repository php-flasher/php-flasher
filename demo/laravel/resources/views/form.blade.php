@extends('layouts.app')

@section('title', 'Form Example - PHPFlasher Laravel Demo')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Form Example</h2>

            <div class="mb-8">
                <p class="text-gray-600">
                    This example demonstrates how PHPFlasher can be used to display form validation errors and success messages.
                </p>
            </div>

            <div class="code-block mb-8">
                <div class="code-header">
                    <span>Controller Code</span>
                </div>
<pre><code class="language-php">public function processForm(Request $request)
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
}</code></pre>
            </div>

            <form action="{{ route('form.process') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject
