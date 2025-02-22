<?php

namespace App\Http\Controllers\Settings;

use Ovds\Money\Currency as MoneyCurrency;
use App\Abstracts\Http\Controller;
use App\Http\Requests\Setting\Currency as Request;
use App\Jobs\Setting\CreateCurrency;
use App\Jobs\Setting\DeleteCurrency;
use App\Jobs\Setting\UpdateCurrency;
use App\Models\Setting\Currency;

class Currencies extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $currencies = Currency::collect();

        return $this->response('settings.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return redirect()->route('currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get current currencies
        $current = Currency::pluck('code')->toArray();

        // Prepare codes
        $codes = [];
        $currencies = MoneyCurrency::getCurrencies();

        foreach ($currencies as $key => $item) {
            // Don't show if already available
            if (in_array($key, $current)) {
                continue;
            }

            $codes[$key] = $key;
        }

        $precisions = (object) [
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ];

        return view('settings.currencies.create', compact('codes', 'precisions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->ajaxDispatch(new CreateCurrency($request));

        if ($response['success']) {
            $response['redirect'] = route('currencies.index');

            $message = trans('messages.success.created', ['type' => trans_choice('general.currencies', 1)]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('currencies.create');

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Currency  $currency
     *
     * @return Response
     */
    public function edit(Currency $currency)
    {
        // Get current currencies
        $current = Currency::pluck('code')->toArray();

        // Prepare codes
        $codes = [];
        $currencies = MoneyCurrency::getCurrencies();

        foreach ($currencies as $key => $item) {
            // Don't show if already available
            if (($key != $currency->code) && in_array($key, $current)) {
                continue;
            }

            $codes[$key] = $key;
        }

        // Set default currency
        $currency->default_currency = ($currency->code == default_currency()) ? 1 : 0;

        $precisions = (object) [
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ];

        return view('settings.currencies.edit', compact('currency', 'codes', 'precisions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Currency $currency
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Currency $currency, Request $request)
    {
        $response = $this->ajaxDispatch(new UpdateCurrency($currency, $request));

        if ($response['success']) {
            $response['redirect'] = route('currencies.index');

            $message = trans('messages.success.updated', ['type' => $currency->name]);

            flash($message)->success();
        } else {
            $response['redirect'] = route('currencies.edit', $currency->id);

            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    /**
     * Enable the specified resource.
     *
     * @param  Currency $currency
     *
     * @return Response
     */
    public function enable(Currency $currency)
    {
        $response = $this->ajaxDispatch(new UpdateCurrency($currency, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => $currency->name]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Currency $currency
     *
     * @return Response
     */
    public function disable(Currency $currency)
    {
        $response = $this->ajaxDispatch(new UpdateCurrency($currency, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => $currency->name]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Currency $currency
     *
     * @return Response
     */
    public function destroy(Currency $currency)
    {
        $response = $this->ajaxDispatch(new DeleteCurrency($currency));

        $response['redirect'] = route('currencies.index');

        if ($response['success']) {
            $message = trans('messages.success.deleted', ['type' => $currency->name]);

            flash($message)->success();
        } else {
            $message = $response['message'];

            flash($message)->error()->important();
        }

        return response()->json($response);
    }

    public function config()
    {
        $json = new \stdClass();

        $code = request('code');

        if ($code) {
            $currencies = Currency::all()->pluck('rate', 'code');

            $currency = (object) currency($code)->toArray()[$code];

            $currency->rate = isset($currencies[$code]) ? $currencies[$code] : null;
            $currency->symbol_first = ! empty($currency->symbol_first) ? 1 : 0;

            $json = $currency;
        }

        return response()->json($json);
    }
}
