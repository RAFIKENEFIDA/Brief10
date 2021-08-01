@extends('layouts.app')

@section('section1')
<div class="container">
    <div class="row pt-5">
        <form class="col-lg-6 form" action="{{route('dashboard')}}" method="GET">
            
        @csrf
            <!-- Full Name -->
            <div class="box d-flex form-group ">
                <!-- Last Name -->
                <div class="col me-3 mb-3">

                    <label for="exampleInputEmail1">Username</label>
                    <input aria-describedby="emailHelp" class="  form-control " type="text"
                        placeholder="Enter your first name" id="example-date-input" name="username"
                        value="{{old('username' ?? null)}}"    @error('username') style="border-color:red"  @enderror>
                        @error('username')

                        <p style="color:red">{{$message}}</p>

                        @enderror
                </div>


                <!-- Last Name -->
    
            </div>
            <!-- date and id -->

            <!-- Email and tele number -->
            <div class="box ">
                <!-- date -->
                <div class="col me-3  mb-3">

                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" placeholder="Enter your email"
                        id="example-date-input" name="email" value="{{old('email' ?? null)}}" >
                        @error('email')

                        <p style="color:red">{{$message}}</p>

                        @enderror
                </div>
                <!-- Last Name -->

            </div>
            <!-- Password -->
            <div class="box d-flex ">
                <!-- Last Name -->
                <div class="col  me-3 mb-3">

                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" placeholder="**************"
                        id="example-date-input" name="password" value="{{old('password' ?? null)}}" >
                        @error('password')

                        <p style="color:red"> {{$message}}</p>

                        @enderror

                 
                </div>
                <!-- test -->

                <!-- Last Name -->
                <div class="col mb-3">

                    <label for="exampleInputPassword1">Repeat Password</label>
                    <input type="password" class="form-control" name="repeat_password"
                        placeholder="**************" id="example-date-input" value="{{old('repeat_password' ?? null)}}" >
                        @error('repeat_password')

                        <p style="color:red">{{$message}}</p>

                        @enderror
                </div>
            </div>
            <!-- Button -->
            <button type="submit" class="btn btn-primary btn-lg " name="submit">Register</button>







        </form>


    </div>

</div>

@endsection
    