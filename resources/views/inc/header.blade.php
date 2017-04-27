<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>St. John Paul College</title>
	{!! Html::style('../resources/assets/css/font-awesome-4.1.0/css/font-awesome.css') !!}
    {!! Html::style('../resources/assets/css/bootstrap.min.css') !!}
    {!! Html::style('../resources/assets/css/bootstrap-datepicker.css') !!}
    {!! Html::style('../resources/assets/css/timepicker.css') !!}
    

    <!-- Custom CSS -->
    {!! Html::style('../resources/assets/css/sb-admin.css') !!}

    <!-- Morris Charts CSS -->
    {!! Html::style('../resources/assets/css/plugins/morris.css') !!}

    {!! Html::style('../resources/assets/css/style.css') !!}

    <!-- Custom Fonts -->
    {{-- <link href="../resources/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> --}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('home') }}">Control Panel&nbsp;&nbsp;<span style="font-size:10px;">St John Paul College</span></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <{{-- li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li> --}}
                <li class="dropdown">
                    {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a> --}}
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('users').'/'.Auth::user()->id.'/edit' }}"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                  {{--       <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li> --}}
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('logout') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">

                	<?php if(Auth::user()->user_type == 0): ?>
                    <li class="active">
                        <a href="{{url('admin')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                   
                    <li>
                        <a href="{{ url('subjects') }}"><i class="fa fa-fw fa-table"></i> Subjects Management</a>
                    </li>
                    <li>
                        <a href="{{ url('questions') }}"><i class="fa fa-fw fa-edit"></i> Questions Management</a>
                    </li>
                    <li>
                        <a href="{{ url('departments') }}"><i class="fa fa-fw fa-university"></i> Department Management</a>
                    </li>
                    
                   {{--  <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse"> --}}
                    <li>
                        <a href="{{ url('users') }}"><i class="fa fa-fw fa-user"></i> Administrators</a>
                    </li>
                            


                  {{--       </ul>
                    </li> --}}

                    <li>
                        {{-- <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a> --}}
                        <a href="javascript:;" data-toggle="collapse" data-target="#settings"><i class="fa fa-fw fa-wrench"></i> Settings <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="settings" class="collapse">
                            <li>
                                <a href="{{ url('evaluations') }}">Setup Evaluation</a>
                            </li>
                            <li>
                                <a href="{{ url('question_categories') }}">Question Categories</a>
                            </li>

                            <li>
                                <a href="{{ url('settings/edit') }}">Dashboard Settings</a>
                            </li>


                        </ul>

                    </li>
                    <?php endif; ?>


                    <li>
                        <a href="{{url('teachers')}}"><i class="fa fa-fw fa-users"></i> Teachers</a>
                    </li>

                    <li>
                        <a href="{{ url('results') }}"><i class="fa fa-fw fa-bar-chart-o"></i> Evaluation Results</a>
                    </li>

                    <li>
                        <a href="{{ url('import') }}"><i class="fa fa-fw fa-upload"></i> Import Excel</a>
                    </li>

              {{--       <li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li> --}}
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">

                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?= (isset($controller)) ? str_replace('_', ' ', ucfirst($controller)) : 'Dashboard' ?> <small> Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard <?= (isset($controller)) ? "/ <a href=".url($controller)." style='color:#777'>".str_replace('_', ' ', ucfirst($controller))."</a>" : '' ?>
                            </li>
                        </ol>
                        {{-- ALERTS --}}
                        @foreach($errors->all() as $error )
                            <div class="alert alert-danger">
                                
                                
                                <p>
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span>
                                {{ $error }}

                                </p>
                            </div>
                        @endforeach

                        @if(Session::has('message'))
                            
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            {{ Session::get('message') }}

                            </p>
                        @endif
                        {{-- END ALERTS --}}
                    </div>
                </div>
                <!-- /.row -->

