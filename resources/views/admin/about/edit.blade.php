@extends('admin.components.layout')
@section('title')
    Update About | Online Shop
@endsection

@section('content')
    <div class="content-header">
        <!-- leftside content header -->
        <div class="leftside-content-header">
            <ul class="breadcrumbs">
                <li><i class="fa fa-home" aria-hidden="true"></i><a href="{{route('home')}}">Dashboard</a></li>
                <li><a href="javascript:avoid(0)">Update About</a></li>
            </ul>
        </div>
    </div><br/><br/><br/><br/><br/><br/>
    <!-- =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= -->
    <div class="row animated shake">
        <div class="col-md-12 ">

            @includeIf('message.message')

            <div class="panel b-primary bt-md">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-6"><h3> Update About</h3></div>
                        <div class="col-sm-6">
                            <a class="btn btn-primary pull-right" href="{{route('abouts.manage')}}">Manage About</a>
                        </div>
                    </div>

                    <form class="form-horizontal" method="post" action="{{ route('abouts.update', $abouts->id) }}">
                        @csrf


                        <div class="form-group">
                            <label for="long_desc" class="col-sm-3 control-label">Long Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" cols="30" rows="10" name="long_desc" id="long_desc"  value="{{ $abouts->id }}" >{{$abouts->long_desc}}</textarea>
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary ">Update About</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

