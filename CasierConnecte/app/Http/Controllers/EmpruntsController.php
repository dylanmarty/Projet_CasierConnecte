<?php

namespace App\Http\Controllers;

use App\Services\EmpruntService;
use App\Services\SmsService;
use App\Models\Emprunt;
use App\Models\Materiel;
use App\Models\Adherent;
use Illuminate\Http\Request;

class EmpruntsController extends Controller
{
    public function getEmprunts()
    {
        $emprunts = Emprunt::with(['materiel', 'adherent'])->get();
        return view('historique', ['emprunts' => $emprunts]);
    }

    public function index(EmpruntService $empruntService)
    {
        $empruntService->verifierEmpruntsEnRetard();
    }
    public function sendMessage(Request $request)
    {
        $empruntId = $request->input('empruntId');
        $message = $request->input('message');

        $emprunt = Emprunt::find($empruntId);
        $phoneNumber = $emprunt->adherent->num_telephone;

        $smsService = new SmsService();
        $smsService->sendSms($phoneNumber, $message);

        return redirect()->back()->with('success', 'Message envoyé avec succès!');
    }
}
