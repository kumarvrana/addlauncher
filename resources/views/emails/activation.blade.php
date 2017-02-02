<h1>Hello</h1>
<p>
    Please, click the following link to activate your account,
    <a href="{{ env('APP_URL') }}user/activate/{{$user->email}}/{{$code}}">Click Here To Activate</a>
</p>