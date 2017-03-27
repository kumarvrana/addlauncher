@extends('layouts.master')

@section('title')
    Thank You|Add Launcher 
@endsection

@section('content')
        <div class="container wrapper">
            <div class="row cart-head">
                <h1>Thank You For Ordering With Us!</h1></hr>
            </div> 
            <div class="order-info">
            @PHP
                echo "<pre>";
                print_r($order);
                echo "</pre>";
            @ENDPHP
                @foreach($order as $ord)
                    {{unserialize($ord['cart'])}}
                    {{$ord['address']}}
                @endforeach
            </div>
            <div class="online-payment">
                <div class="sub-content">
                <h3>Online Payment</h3>
                <div class="description-cashpayment">
                    - Mention your brand name in description section Cheque Payment
                    - Send us a scanned copy of the cheque to info@addlauncher.com and courier the cheque to:
                    Adlauncher, Best Sky Tower, NSP, Pitampura - 110034 phone no: +011-4557685
                </div>
                <div class="bank-details">
                    Bank Name 	HDFC Bank
                    Account Name 	Adlauncher
                    Account Number 	account-number
                    Account Type 	Current Account
                    IFSC 	ifsc-code
                </div>
            </div>
        </div>

@endsection
