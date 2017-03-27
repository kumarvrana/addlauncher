@extends('backend.layouts.backend-master')

@section('title')
   Cash Transfer Settings | Add Launcher
@endsection

@section('content')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Cash Transfer Settings</h1>
            <div class="col-sm-9 col-sm-offset-1 col-md-6 col-md-offset-1">
             @if(count($errors) > 0 )
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success">
                    <p>{{Session::get('message')}}</p>
                </div>
            @endif

            @PHP
                
                $Settings = unserialize($settings->payment_secret);
               
            @ENDPHP
         
           <form class="form" action="{{route('dashboard.addcashtransfer')}}" method="post" enctype="multipart/form-data">
        <div class="step">
           
                
                <div class="form-group">
                    <label for="accountno">Account no.:</label>
                    <input type="text" id="accountno" name="accountno" class="form-control" value="" placeholder="Account number eg: 222343561213" required>
                </div>

                <div class="form-group">
                    <label for="accountname">Account name:</label>
                    <input type="text" id="accountname" name="accountname" placeholder="example: Maharashtra" value="" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label for="accounttype">Account Type:</label>
                    <input type="text" id="accounttype" name="accounttype" class="form-control" value="" placeholder="Account number eg: 222343561213" required>
                </div>
                
                <div class="form-group">
                    <label for="bankname">Bank Name:</label>
                    <input type="text" id="bankname" name="bankname" placeholder="example: Maharashtra" value="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="bankbranch">Bank branch:</label>
                    <input type="text" id="bankbranch" name="bankbranch" placeholder="example: ICICI" value="" class="form-control" required>
                </div>
                             
                <div class="form-group">
                    <label for="ifsc">IFSC code:</label>
                    <input type="text" id="ifsc" name="ifsc" placeholder="ALLA0213139" value="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="branchcode">Branch code:</label>
                    <input type="text" id="branchcode" name="branchcode" placeholder=" 213139" value="" class="form-control" required>
                </div>
                
        {{csrf_field()}}
        
       
        <button type="submit" class="action submit btn btn-success">Submit</button>    
    </form>
            </div>
            
      

        </div>
      
        
@endsection

@section('scripts')

<script>
    
</script>

@endsection