
@extends('layouts.default') 

@section('title')
List of Students
@endsection

@section('content')
<style>
    .content-body {
        margin: 0px !important;
    }
</style>
<div class="kt-pagetitle">
    <h5>Students</h5>
</div>
<!-- kt-pagetitle -->

<div class="kt-pagebody">
    @if(Session::has('error'))
    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{!! Session::get('error') !!}</p>
    @endif

    @if(Session::has('success'))
    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! Session::get('success') !!}</p>
    @endif

  

    @if (isset($students))
    <div class="content-wrapper">
      

           
<div class="table-responsive">
            <table class="table table-striped mg-b-0 mg-t-20 table-hover table-success table-bordered">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th class="hidden-xs-down">FirstName</th>
                        <th class="hidden-xs-down">MiddleName</th>
                        <th class="hidden-xs-down">LastName</th>
                        <th class="hidden-xs-down">Gender</th>
                        <th class="hidden-xs-down">Phone</th>
                        <th class="hidden-xs-down">Email</th>
                        <th class="hidden-xs-down">Course</th>
                        <th class="hidden-xs-down">School</th>
                        <th class="hidden-xs-down">Biography</th>
                       
                    </tr>
                </thead>
                <tbody id="cat-tb-bdy">
                    @foreach($students as $student)


                    <tr id="{{$student->id}}">
                    
                     <td>
                           
                                <span class="pd-l-5">{{$student->id }}</span>
                            
                        </td>
                        <td>
                           
                                <span class="pd-l-5">{{ $student->firstName }}</span>
                            
                        </td>
                       
                        <td class="hidden-xs-down">{{ $student->middleName }}</td>
                   
                        <td class="hidden-xs-down">{{ $student->lastName }}</td>
                        <td class="hidden-xs-down">{{ $student->gender }}</td>
                        <td class="hidden-xs-down">{{ $student->phone }}</td>
                        <td class="hidden-xs-down">{{ $student->email }}</td>
                        <td class="hidden-xs-down">{{ $student->course }}</td>
                        <td class="hidden-xs-down">{{ $student->school }}</td>
                            
                        <td class="hidden-xs-down">{{ $student->Biography}}</td>
                            
                        
                    </tr>
                    @endforeach

                </tbody>
            </table>
            </div>
        </div>
    
        <!-- content-body -->
    </div>
    @endif
    <!-- content-wrapper -->
</div>
<!-- kt-pagebody -->
<style>

    a {
        text-transform: none;
        text-decoration: none !important;
    }
    td a {
        text-decoration: none !important;
        color: inherit;
        font-weight: bolder;
    }
</style>
@stop
