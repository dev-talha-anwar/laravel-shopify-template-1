@extends('vendor.shopify-app.layouts.default') 
@section('styles')
<link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('assets') }}/css/ladda-themeless.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/css/style.css">

<link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection 
@section('content')
<div class="container">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home">App Setting</a>

        </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu1">Help and Support</a>

        </li>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu2">FAQ</a>

        </li>
    </ul>
    <div class="tab-content">
        <!--------------------Tab-1----------------------->
        <div id="home" class="container-fluid tab-pane active">
            <br>
           {{-- @include('includes.messages') --}}
            <div class="row">
                <div class="col-md-12 app m_b">
                    <div class="col-md-10">
                        <p>
                            App Status
                        </p>
                    </div>
                    <div class="col-md-2">
                        <div class="fb-button">
                            <button class="btn fb-icon-btn btn-primary ladda-button changestatus" data-style="zoom-in">
                                <span class="ladda-label">{{ auth()->user()->settings->enable ? "Enabled" : "Disabled" }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 choose m_b">
                    <div class="col-md-4">
                        <h4>Choose Currencies</h4>

                        <p>
                            Choose the Currencies that will appear in the Currency Switcher on your Shopify store out of 150+ currencies.
                        </p>
                        <h4>Default Currency</h4>

                        <div class="default-currency-wrapper">
                            <div class="__selectedCountry_image">
                                {{-- <img src="https://www.countryflags.io/US/flat/64.png"> --}}
                            </div>
                            <p class="__selectedCountry_title">
                                {{ auth()->user()->default_currency }}
                            </p>
                        </div>
                        <p>
                            <i>Note : Default currency will automatically get inserted in currency converter, you are not allowed to add or remove default currency.</i>

                        </p>
                    </div>
                    <div class="col-md-8 choose_currency">
                        <form action="{{ route('savecurrencies') }}" method="post" class="updateform">
                            <label>Currencies</label>
                            <div class="form-group">
                                <select class="js-example-basic-single" name="countries[]" class="form-control" multiple="multiple">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if(in_array($country->id, $user_currencies) === true) selected="selected" @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-secondary ladda-button remove-all" data-style="zoom-in">
                                <span class="ladda-label">Remove all</span>
                            </button>
                            <button class="btn btn-primary ladda-button savebutton" data-style="zoom-in">
                                <span class="ladda-label">Save</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 jumbotron">
                    Instructions For Money Format Setup <br>
                    Step 1: Go to Shopify Settings -> General <br>
                    Step 2: Click on Change Formatting in Store currency section <br>
                    Step 3: Copy & Paste the above Money Formats like the following. <br>
                    HTML with currency 
                    <input class="form-control" type="text" disabled="" value="<span class=alphamoney>$@{{amount}} USD</span>"/>
                    HTML without currency  
                    <input class="form-control" type="text" disabled="" value="<span class=alphamoney>$@{{amount}}</span>"/>
                </div>
                <div class="col-md-12 jumbotron">
                    Auto Switch Currency Based On Location ?
                    <label class="switch">
                        <input class="geolocation" type="checkbox" @if(auth()->user()->settings->geolocation) checked @endif>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--------------------Tab-2----------------------->
        <div id="menu1" class="container-fluid tab-pane fade">
            <br>
            <div class="form-contact">
                <form class="contactform" method="post">
                    <div class="form-group">
                        <label>Email:</label>
                        <input name="email" type="text" class="form-control input-height">
                    </div>
                    <div class="form-group">
                        <label>Subject:</label>
                        <input name="subject" type="text" class="form-control input-height">
                    </div>
                    <div class="form-group">
                        <label>Message:</label>
                        <textarea name="message" class="form-control" placeholder="Write something.." style="height:200px"></textarea>
                    </div>
                </form>
                <div class="contact-button">
                    <button class="btn btn-primary ladda-button sendbutton" data-style="zoom-in">
                        <span class="ladda-label">Send</span>
                    </button>
                </div>
            </div>
        </div>
        <!--------------------Tab-3----------------------->
        <div id="menu2" class="container-fluid tab-pane fade">
            <br>
            <div class="container demo">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <!-------------1------------->
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                    Currency Converter Ultimate Prices in checkout page still show in shop currency. Why?
                                </a>
                            </h4>

                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                Although our app converts prices on your store, order processing is being done using original shop currency. Shopify system does not allow us to change currency on your checkout page. If you wish to add a notification saying above matter to your customers
                                on your cart page or any other location, please send us a message. ALPHA support is looking forward to helping you to do that.
                            </div>
                        </div>
                    </div>
                    <!-------------2------------->
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                    Currency selector dropdown does not populate correctly. Why?
                                </a>
                            </h4>

                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                It maybe due to browser caching. Please remove your browser cache and reload the pageIf it does not work please kindly contact ALPHA support.
                            </div>
                        </div>
                        <!-------------3------------->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        Auto-switching based on visitor's location doen't work. How to fix it?
                                    </a>
                                </h4>

                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    It works only for first-time visitors. Once a user visits the site, our app keeps a record of the geo-based currency of the visitor on the visitor's browser and automatically switch the currency accordingly. From onwards, the app uses the currency type
                                    kept in the browser record or the currency type manually set by the visitor. If you want to test it, please open the website from a different web browser.
                                </div>
                            </div>
                        </div>
                        <!-------------4------------->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        What is the meaning of "show original price as a tooltip"?
                                    </a>
                                </h4>

                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    Although our app converts prices on your store, order processing is being done using original shop currency. Therefore, if you have enabled "Show original price as a tooltip" from settings, visitors can see the price in shop currency when they move the
                                    mouse on top of the price tag for a while.
                                </div>
                            </div>
                        </div>
                        <!-------------5------------->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        How does currency exchange updating rate affect to my website?
                                    </a>
                                </h4>

                            </div>
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">
                                    Currency exchange rates are varying small amounts from time to time. Hence, more frequent exchange updates result in more accurate price conversions.
                                </div>
                            </div>
                        </div>
                        <!-------------6------------->
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                        I want to have the currency selecting dropdown, as shown in the demo page. What should I do to have that?
                                    </a>
                                </h4>

                            </div>
                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                <div class="panel-body">
                                    Thank you for your interest. Unfortunately, no
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- panel-group -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@section('scripts') 
    @parent
    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Welcome',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
    <script type="text/javascript" src="{{ asset('assets') }}/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/js/spin.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/js/ladda.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets') }}/js/notify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                width: "100%",
                multiple: true
            });
            $('.savebutton').on('click',function(e){
                e.preventDefault();
                ajax_request('POST' , "{{ route('savecurrencies') }}" , $('.updateform').serialize() , this);

            });
            $('.changestatus').on('click',function(e){
                e.preventDefault();
                ajax_request( 'GET' , "{{ route('changestatus') }}" , undefined , this , { field: this});

            });
            $('.sendbutton').on('click',function(e){
                e.preventDefault();
                ajax_request( 'POST' , "{{ route('contact.store') }}" , $('.contactform').serialize() , this );
            });
            $('.geolocation').on('change',function(){
                ajax_request( 'GET' , "{{ route('geolocation') }}");
            });
            $('.remove-all').on('click',function(e){
                e.preventDefault();
                let button = $(this);
                var l = Ladda.create(this);
	 	        l.start();
	 	        $(".js-example-basic-single").val("{{ $default_country }}").trigger('change');;
	 	        l.stop();
            });
            function ajax_request(method = 'GET',url = undefined , data = {} ,button = undefined , text = undefined){
                if(button){
                    var l = Ladda.create(button);
	 	            l.start();
                }
                $.ajax({
                    url:url,
                    method:method,
                    data: data
                }).done(function(response){
                    messages(response);
                    if(text){
                        changeText(text,response);
                    }
                }).always(function(){
                    if(button){
                        l.stop();
                    }
                });
            }
            function messages(response = undefined){
                if(response.hasOwnProperty('success')){
                    $.notify(response.success, "success");
                }else if(response.hasOwnProperty('error')){
                    $.notify(response.error, "error");
                }else if(response.hasOwnProperty('errors')){
                    $.each(response.errors,function(index,error){
                        $.notify(error, "error");
                    });
                }
            }
            function changeText(text , response){
                if(response.hasOwnProperty('success')){
                    $(text.field).html(response.success);
                }
            }
        });
        
        function toggleIcon(e) {
            $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    </script>
@endsection