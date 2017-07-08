@extends('app')

@section('header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
    <div data-group="{{ $data->public_id }}"></div>
    <div class="container mt30">

        <div class="row">

            <div class="col-md-9">

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3> Search Cheapest Flights </h3>
                        </div>
                    </div>
                    <div class="panel-body">

                            <?php use AdamWathan\BootForms\Facades\BootForm; ?>


                            <div class="row">

                                <div style="margin:10px;">

                                    <?= BootForm::open()->post()->action(action('IndexController@store')) ?>                                    

                                    <?= BootForm::select('', 'from')->class('remote-selector')->style('    height: 30px;')->placeholder('Where are you flying from?') ?>
                                    <?= BootForm::select('', 'fromT')->class('remote-selector')->style('    height: 30px;')->placeholder('Where are you flying to?') ?>

                                    <p>Date: <input type="text" id="datepickerF">  <input type="text" id="datepickerT"></p>


                                    <p>
                                        Adult: <input class="spinner"> Children: <input class="spinner"> Infants: <input class="spinner">

                                        <select class="selectpicker">
                                            <option>Economy</option>
                                            <option>Premium Economy</option>
                                            <option>Business Class</option>
                                            <option>First Class</option>
                                        </select>
                                    
                                    </p>
                                    

                                    {!! BootForm::submit('GO!', 'btn btn-sky btn-block')->style('color:white;') !!}

                                    <?= Bootform::close() ?>

                                </div>

                            </div>
                        
                    </div>
                    
                </div>

                <div class="panel panel-primary">

                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3> Results
                                <div style="float:right;">
                                    <ul>
                                        <li>
                                           <div style="margin-top:5px;"> <a href="https://twitter.com/share"
                                               class="twitter-share-button" data-size="small">Tweet</a>
                                               </div>
                                            <div class="fb-share-button"
                                                 data-href="{{\Request::url()}}"
                                                 data-layout="button_count"
                                                    style="z-index:10;">
                                            </div>
                                        </li>
                                    </ul>



                                </div>

                            </h3>
                        </div>

                    </div>

                    <div class="panel-body">


                        <div class="panel-body">

                            <div class="row result mb15">
                                <div class="col-md-1">

                                </div>
                                <div class="col-md-3">
                                    <p class="header">Destination</p>
                                </div>

                                <div class="col-md-5">
                                    <p class="header">Date (Depart - Return)</p>
                                </div>

                                <div class="col-md-2">
                                    <p class="header">Price </p>
                                </div>
                                <div class="col-md-1">

                                </div>

                            </div>

                        </div>

                        <div class="panel-body" id="body">


                            @foreach($data->getFlightsByVoteCount() as $flight)

                                @include('partials.result-row')
                            @endforeach


                        </div>


                    </div>

                </div>


            </div>


            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3> Info </h3>
                        </div>
                    </div>
                    <div class="panel-body">

                        <p>You have searched for flights from <b>{{ $data->from }}</b> airport, we have found
                            <b> {{ $data->flights()->count() }}</b> flights from this destination. </p>

                        <p>Cheapest flight cost <b>£{{ $data->flights()->orderBy('price', 'asc')->first()->price }}</b>
                            and most expensive one costs
                            <b>£{{ $data->flights()->orderBy('price', 'desc')->first()->price }}.</b></p>

                        <p>This board was created <b>{{ $data->created_at->diffForHumans() }}</b></p>
                        <p>Refreshed: <b>{{ $data->created_at->eq($data->updated_at) ? 'Never' : $data->updated_at->diffForHumans() }}</b></p>

                        <a href="?refresh=true" class="btn btn-danger btn-block">Refresh Data!</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3> Chat </h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="comments" id="chat" style="height:200px; overflow:auto;">
                            @foreach($comments as $comment)
                                <p>{{$comment->text}}<small style="float:right;">{{ $comment->created_at->diffForHumans() }}</small></p>
                                <hr>
                            @endforeach
                        </div>

                            <?= BootForm::open()->post()->action(action('CommentsController@store'))->id('comments__create-form') ?>
                            {!! BootForm::hidden('group_id')->value($data->id) !!}
                            {!! BootForm::text('', 'text')->id('comment-input')->autocomplete("off") -> placeholder("Please enter message") !!}
                            <?= Bootform::close() ?>


                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@section('javascript')

    <script>
        /* Hit enter to submit comment */
        $('#comments__create-form').on('submit', function (e) {
            e.preventDefault();
            var myVariable = document.querySelector('.comments').id;
            var form = $(this);
            var post_url = form.attr('action');
            var post_data = form.serialize();
            var a = document.getElementById("comment-input");
            a.value = "";
            $('#' + myVariable).load(document.URL + ' #' + myVariable);
            $.ajax({
                type: 'POST',
                url: post_url,
                data: post_data,
                success: function () {
                }

            });


        });




            function autoRefresh_div()
            {
                var myVariable = document.querySelector('.comments').id;
                $('#'+myVariable).load(document.URL +' #'+myVariable);
            }
            setInterval('autoRefresh_div()', 2000);


    </script>

    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

    <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));</script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
	<script>
        $( function() {
            $( "#datepickerF" ).datepicker();
            $( "#datepickerT" ).datepicker();
        } );
    </script>

    <script>
        $( ".spinner" ).spinner({min: 0});
    </script>
@endsection

