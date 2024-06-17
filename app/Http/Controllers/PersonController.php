<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::all();
        return view('persons.index', compact('persons'));
    }

    public function create()
    {
        return view('persons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:persons,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,supervisor,employee',
        ]);

        Person::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('persons.index')->with('success', 'Person created successfully.');
    }

    public function show($id)
    {
        $person = Person::findOrFail($id);
        return view('persons.show', compact('person'));
    }

    public function edit($id)
    {
        $person = Person::findOrFail($id);
        return view('persons.edit', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:persons,email,' . $id,
            'role' => 'required|in:admin,supervisor,employee',
        ]);

        $person = Person::findOrFail($id);
        $person->update($request->all());

        return redirect()->route('persons.index')->with('success', 'Person updated successfully.');
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();
        return redirect()->route('persons.index')->with('success', 'Person deleted successfully.');
    }
}
