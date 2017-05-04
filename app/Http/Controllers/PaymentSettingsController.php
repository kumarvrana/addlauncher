<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\PaymentSetting;

class PaymentSettingsController extends Controller
{

  public function __construct()
    {
        $this->middleware('admin', ['only' => ['getCashTransfer', 'postCashTransfer', 'UpdateCashPayment', 'getCitrusTransfer', 'postCitrusTransfer', 'UpdateCitrusPayment', 'getStripeTransfer' , 'postStripeTransfer' , 'UpdateStripePayment']]);
    }
    // cash payment 

    public function getCashTransfer()
    {
        $aftercashpayment = PaymentSetting::find(2);
        return view('backend.paymentsettings.cashtransfer')->with('settings', $aftercashpayment);
    }
    public function postCashTransfer(Request $request)
    {
         // dd($request->all());
        $this->validate( $request, [
           'accountno' => 'numeric',
           'accountname' => 'required',
           'accounttype' => 'required',
           'bankname' => 'required',
           'bankbranch' => 'required',
           'ifsc' => 'required',
           'branchcode' => 'required'

        ]);

        $payment_secret_value = array(
                                    'accountno' => $request->input('accountno'),
                                    'accountname' => $request->input('accountname'),
                                    'accounttype' => $request->input('accounttype'),
                                    'bankname' => $request->input('bankname'),
                                    'bankbranch' => $request->input('bankbranch'),
                                    'ifsc' => $request->input('ifsc'),
                                    'branchcode' => $request->input('branchcode')
                                  );
       

        $cashpayment = new PaymentSetting([
                'payment_method' => 'cash transfer',
                'payment_secret' => serialize($payment_secret_value),
                
        ]);

        $cashpayment->save();

        
        return redirect()->back('dashboard.updatecashtransfer')->with('settings', $aftercashpayment);
        

    }

    public function UpdateCashPayment(Request $request)
    {
        $this->validate( $request, [
           'accountno' => 'numeric|required',
           'accountname' => 'required',
           'accounttype' => 'required',
           'bankname' => 'required',
           'bankbranch' => 'required',
           'ifsc' => 'required',
           'branchcode' => 'required'

        ]);



        $payment_secret_value = array(
                                    'accountname' => $request->input('accountname'),
                                    'accounttype' => $request->input('accounttype'),
                                    'accountno' => $request->input('accountno'),
                                    'bankname' => $request->input('bankname'),
                                    'bankbranch' => $request->input('bankbranch'),
                                    'ifsc' => $request->input('ifsc'),
                                    'branchcode' => $request->input('branchcode')
                                  );

         $editcash = PaymentSetting::find(2);
         
         $editcash->payment_method = 'cash transfer';
         $editcash->payment_secret = serialize($payment_secret_value);


          $editcash->update();
           return redirect()->route('dashboard.cashtransfer')->with('message', 'Successfully Edited!');


    }
        
   

    // citrus payment
    public function getCitrusTransfer()
    {
        $aftercitruspayment = PaymentSetting::find(14);
        return view('backend.paymentsettings.citrustransfer')->with('settings', $aftercitruspayment);
    }
    public function postCitrusTransfer(Request $request)
    {
         // dd($request->all());
        $this->validate( $request, [
           'accountname' => 'required',
           'accountno' => 'numeric',
           'bankname' => 'required',
           'secretkey' => 'required',
           'accesskey' => 'required',
           'vanityurl' => 'required',
           'configuredgmail' => 'required'

        ]);

        $payment_secret_value = array(
                                    'accountname' => $request->input('accountname'),
                                    'accountno' => $request->input('accountno'),
                                    'bankname' => $request->input('bankname'),
                                    'secretkey' => $request->input('secretkey'),
                                    'accesskey' => $request->input('accesskey'),
                                    'vanityurl' => $request->input('vanityurl'),
                                    'configuredgmail' => $request->input('configuredgmail')
                                  );
       

        $citruspayment = new PaymentSetting([
                'payment_method' => 'citrus transfer',
                'payment_secret' => serialize($payment_secret_value),
                
        ]);

        $citruspayment->save();

        
        return redirect()->back('dashboard.updatecitrustransfer')->with('settings', $aftercitruspayment);
        

    }

    public function UpdateCitrusPayment(Request $request)
    {
        $this->validate( $request, [
           'accountname' => 'required',
           'accountno' => 'numeric',
           'bankname' => 'required',
           'secretkey' => 'required',
           'accesskey' => 'required',
           'vanityurl' => 'required',
           'configuredgmail' => 'required'

        ]);



        $payment_secret_value = array(
                                    'accountname' => $request->input('accountname'),
                                    'accountno' => $request->input('accountno'),
                                    'bankname' => $request->input('bankname'),
                                    'secretkey' => $request->input('secretkey'),
                                    'accesskey' => $request->input('accesskey'),
                                    'vanityurl' => $request->input('vanityurl'),
                                    'configuredgmail' => $request->input('configuredgmail')
                                  );

         $editcitrus = PaymentSetting::find(14);
         
         $editcitrus->payment_method = 'citrus transfer';
         $editcitrus->payment_secret = serialize($payment_secret_value);


          $editcitrus->update();
           return redirect()->route('dashboard.citrustransfer')->with('message', 'Successfully Edited!');


    }

    // stripe payment
    public function getStripeTransfer()
    {
        $afterstripepayment = PaymentSetting::find(19);
        return view('backend.paymentsettings.stripetransfer')->with('settings', $afterstripepayment);
    }

    public function postStripeTransfer(Request $request)
    {
         // dd($request->all());
        $this->validate( $request, [
           'accountname' => 'required',
           'accountno' => 'numeric',
           'bankname' => 'required',
           'secretkey' => 'required',
           'accesskey' => 'required',
           'bankbranch' => 'required',
           'configuredgmail' => 'required'

        ]);

        $payment_secret_value = array(
                                    'accountname' => $request->input('accountname'),
                                    'accountno' => $request->input('accountno'),
                                    'bankname' => $request->input('bankname'),
                                    'secretkey' => $request->input('secretkey'),
                                    'accesskey' => $request->input('accesskey'),
                                    'bankbranch' => $request->input('bankbranch'),
                                    'configuredgmail' => $request->input('configuredgmail')
                                  );
       

        $stripepayment = new PaymentSetting([
                'payment_method' => 'stripe transfer',
                'payment_secret' => serialize($payment_secret_value),
                
        ]);

        $stripepayment->save();

        
        return redirect()->back('dashboard.updatestripetransfer')->with('settings', $afterstripepayment);
        

    }

    public function UpdateStripePayment(Request $request)
    {
        $this->validate( $request, [
           'accountname' => 'required',
           'accountno' => 'numeric',
           'bankname' => 'required',
           'secretkey' => 'required',
           'accesskey' => 'required',
           'bankbranch' => 'required',
           'configuredgmail' => 'required'

        ]);



        $payment_secret_value = array(
                                    'accountname' => $request->input('accountname'),
                                    'accountno' => $request->input('accountno'),
                                    'bankname' => $request->input('bankname'),
                                    'secretkey' => $request->input('secretkey'),
                                    'accesskey' => $request->input('accesskey'),
                                    'bankbranch' => $request->input('bankbranch'),
                                    'configuredgmail' => $request->input('configuredgmail')
                                  );

         $editcitrus = PaymentSetting::find(19);
         
         $editcitrus->payment_method = 'stripe transfer';
         $editcitrus->payment_secret = serialize($payment_secret_value);


          $editcitrus->update();
           return redirect()->route('dashboard.stripetransfer')->with('message', 'Successfully Edited!');


    }
}
