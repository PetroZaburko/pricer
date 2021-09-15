<?php

namespace App\Http\Controllers;

use App\AdvertsHistory;
use App\History;
use Illuminate\Support\Facades\Auth;

class HistoriesController extends Controller
{
    public function index()
    {
//      $histories = History::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc');
//      return view('pages.history',['histories' => $histories->toJson()]);

        $histories = History::where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->get();
        $result = [];
        foreach ($histories as $history) {
            $elem = [
                'id' => "<b><a href=" . route('history.details', ['id' => $history->id]) .">$history->id</a></b>",
                'date' => $history->created_at->format('d-m-Y'),
                'time' => $history->created_at->format('H:i:s'),
                'category'=> $history->category->title,
                'action' => $history->getFormattedAction(),
                'author' => $history->user->name,
                'company' => $history->company->name
            ];
            array_push($result, $elem);
        }
        return view('pages.history',['result' => json_encode($result)]);
    }

    public function details($id)
    {
//        $history = History::find($id);
        $history = History::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
        $details = $history->historyAdverts()->paginate(config('view.per_page'));
        return view('pages.history_adverts', compact('history','details'));
    }
}
