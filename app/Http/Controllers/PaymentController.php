<?php

namespace App\Http\Controllers;

use App\Models\Ire;
use App\Models\Maksajums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    // Izveido Stripe Checkout sesiju un atgriež URL
    public function pay(Request $request, $id)
    {
        $ride = Ire::where('id', $id)
            ->where('lietotajs_id', Auth::id())
            ->firstOrFail();

        if ($ride->statuss !== 'pabeigta') {
            return response()->json([
                'error' => __('messages.ride_must_be_finished')
            ], 400);
        }

        if ($ride->maksajums) {
            return response()->json([
                'error' => __('messages.ride_already_paid')
            ], 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $summaArPvn = round($ride->cena * 1.21, 2);

        // Stripe minimālā summa 0.50€
        $unitAmount = max((int) round($summaArPvn * 100), 50);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => __('messages.stripe_ride_product_name', [
                            'id' => $ride->id
                        ]),
                    ],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'locale' => app()->getLocale() === 'lv' ? 'lv' : 'en',
            'success_url' => route('ride.payment.success', $ride->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('ride.payment.cancel', $ride->id),
        ]);

        return response()->json(['url' => $session->url]);
    }

    public function success(Request $request, $id)
    {
        $ride = Ire::where('id', $id)
            ->where('lietotajs_id', Auth::id())
            ->firstOrFail();

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($request->query('session_id'));

        if ($session->payment_status === 'paid' && !$ride->maksajums) {
            $summaArPvn = $session->amount_total / 100;
            $summaBezPvn = round($summaArPvn / 1.21, 2);

            Maksajums::create([
                'summa_bez_pvn'     => $summaBezPvn,
                'summa_ar_pvn'      => $summaArPvn,
                'maksajuma_veids'   => 'karte',
                'maksajuma_statuss' => 'veikts',
                'maksajuma_datums'  => now(),
                'ire_id'            => $ride->id,
            ]);
        }

        return redirect()
            ->route('review.get', $ride->id)
            ->with('success', __('messages.payment_completed_successfully'));
    }

    // Ja lietotājs atceļ apmaksu
    public function cancel($id)
    {
        return redirect('/')
            ->with('error', __('messages.payment_cancelled'));
    }
}