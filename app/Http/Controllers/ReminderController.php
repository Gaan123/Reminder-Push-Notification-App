<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReminderRequest;
use App\Models\Reminder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ReminderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $reminders = Reminder::paginate(20);
        return view('reminder.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reminder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|Redirector
     */
    public function store(ReminderRequest $request)
    {
        $reminderModel = new Reminder();
        $reminderModel::create($request->only($reminderModel->getFillable()));
        return redirect(route('reminders.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Reminder $reminder)
    {
        return view('reminder.edit', compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Application|\Illuminate\Http\RedirectResponse|Response|Redirector
     */
    public function update(ReminderRequest $request, Reminder $reminder)
    {
        $reminder->update($request->only($reminder->getFillable()));
        return redirect(route('reminders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Reminder::findOrFail($id)->delete();
        return redirect()->back();
    }
}
