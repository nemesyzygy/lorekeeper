<?php

namespace App\Http\Controllers;

use App\Models\Currency\Currency;
use App\Models\Prompt\Prompt;
use App\Models\Prompt\PromptCategory;
use App\Models\SitePage;
use App\Models\User\UserCurrency;
use Auth;
use Illuminate\Http\Request;
use Settings;

class PromptsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Prompts Controller
    |--------------------------------------------------------------------------
    |
    | Displays information about prompts as entered in the admin panel.
    | Pages displayed by this controller form the Prompts section of the site.
    |
    */

    /**
     * Shows the index page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('prompts.index');
    }

    /**
     * Shows the prompt categories page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPromptCategories(Request $request)
    {
        $query = PromptCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('prompts.prompt_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the prompts page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPrompts(Request $request)
    {
        $query = Prompt::active()->staffOnly(Auth::check() ? Auth::user() : null)->with('category');
        $data = $request->only(['prompt_category_id', 'name', 'sort']);
        if (isset($data['prompt_category_id']) && $data['prompt_category_id'] != 'none') {
            $query->where('prompt_category_id', $data['prompt_category_id']);
        }
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
                case 'start':
                    $query->sortStart();
                    break;
                case 'start-reverse':
                    $query->sortStart(true);
                    break;
                case 'end':
                    $query->sortEnd();
                    break;
                case 'end-reverse':
                    $query->sortEnd(true);
                    break;
            }
        } else {
            $query->sortCategory();
        }

        return view('prompts.prompts', [
            'prompts'    => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows the event currency tracking page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEventTracking(Request $request)
    {
        if (!Settings::get('global_event_score')) {
            abort(404);
        }
        $total = UserCurrency::where('user_id', Settings::get('admin_user'))->where('currency_id', Settings::get('event_currency'))->first();

        return view('prompts.event_tracking', [
            'currency'        => Currency::find(Settings::get('event_currency')),
            'total'           => $total,
            'progress'        => $total ? ($total->quantity <= Settings::get('global_event_goal') ? ($total->quantity / Settings::get('global_event_goal')) * 100 : 100) : 0,
            'inverseProgress' => $total ? ($total->quantity <= Settings::get('global_event_goal') ? 100 - (($total->quantity / Settings::get('global_event_goal')) * 100) : 0) : 100,
            'page'            => SitePage::where('key', 'event-tracker')->first(),
        ]);
    }
}
