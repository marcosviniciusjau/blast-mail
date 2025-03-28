<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class EmailListController extends Controller
{
    public function index()
    {
        $search = request()->search;
        $withTrashed = request()->get('withTrashed', false);
        $emailLists = EmailList::query()
        ->withCount('subscribers')
            ->when(
                $search,
                fn (Builder $query) => $query
                    ->where('title', 'like', "%$search%")
                    ->orWhere('id', '=', "%$search%")
            )
            ->paginate(5)
            ->appends(compact('search'), 'withTrashed');

        return view('email-list.index', [
            'emailLists' => $emailLists,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('email-list.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);
        $emails = $this->readCsvFile($request->file('file'));

        DB::transaction(function () use ($request, $emails) {
            $emailList = EmailList::query()->create([
                'title' => $request->title,
            ]);
            $emailList->subscribers()->createMany($emails);
        });

        return to_route('email-list.index');
    }

    private function readCsvFile(UploadedFile $file): array
    {
        $fileHandle = fopen($file->getRealPath(), 'r');
        $items = [];

        while (($row = fgetcsv($fileHandle, null, ',')) !== false) {
            if ($row[0] == 'Name' && $row[1] == 'Email') {
                continue;
            }
            $items[] = [
                'name' => $row[0],
                'email' => $row[1],
            ];
        }

        fclose($fileHandle);

        return $items;
    }

    public function show(EmailList $emailList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailList $emailList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailList $emailList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailList $emailList)
    {
        //
    }
}
