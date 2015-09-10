@extends('app')

@section('header')
        <!-- CSS Implementing Plugins -->
{{--<link rel="stylesheet" href="assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">--}}
<link rel="stylesheet" href="assets/plugins/revolution-slider/rs-plugin/css/settings.css" type="text/css" media="screen">
@endsection


@section('content')



        <!--=== Slider ===-->
<div class="tp-banner-container">
    <div class="tp-banner">
        <ul>
            <!-- SLIDE -->
            <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 1">
                <!-- MAIN IMAGE -->
                <img src="assets/img/sliders/eve1.jpg"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                <div class="tp-caption revolution-ch1 sft start"
                     data-x="center"
                     data-hoffset="0"
                     data-y="100"
                     data-speed="1500"
                     data-start="500"
                     data-easing="Back.easeInOut"
                     data-endeasing="Power1.easeIn"
                     data-endspeed="300">
                    WELCOME TO INELUCTABLE
                </div>

                <!-- LAYER -->
                <div class="tp-caption revolution-ch2 sft"
                     data-x="center"
                     data-hoffset="0"
                     data-y="190"
                     data-speed="1400"
                     data-start="2000"
                     data-easing="Power4.easeOut"
                     data-endspeed="300"
                     data-endeasing="Power1.easeIn"
                     data-captionhidden="off"
                     style="z-index: 6">
                    We are a pvp alliance focused on <br/>
                    small gang warfare based out of Curse
                </div>

                <!-- LAYER -->
                <div class="tp-caption sft"
                     data-x="center"
                     data-hoffset="0"
                     data-y="310"
                     data-speed="1600"
                     data-start="2800"
                     data-easing="Power4.easeOut"
                     data-endspeed="300"
                     data-endeasing="Power1.easeIn"
                     data-captionhidden="off"
                     style="z-index: 6">
                    <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Find Us</a>
                    <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Apply to join</a>
                </div>
            </li>
            <!-- END SLIDE -->

            <!-- SLIDE -->
            <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 2">
                <!-- MAIN IMAGE -->
                <img src="assets/img/sliders/eve2.jpg"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                <div class="tp-caption revolution-ch1 sft start"
                     data-x="center"
                     data-hoffset="0"
                     data-y="100"
                     data-speed="1500"
                     data-start="500"
                     data-easing="Back.easeInOut"
                     data-endeasing="Power1.easeIn"
                     data-endspeed="300">
                    Daily PVP Roams
                </div>

                <!-- LAYER -->
                <div class="tp-caption revolution-ch2 sft"
                     data-x="center"
                     data-hoffset="0"
                     data-y="190"
                     data-speed="1400"
                     data-start="2000"
                     data-easing="Power4.easeOut"
                     data-endspeed="300"
                     data-endeasing="Power1.easeIn"
                     data-captionhidden="off"
                     style="z-index: 6">
                    We are focused on fun small gang pvp <br/>
                    Always outnumbered, never outgunned
                </div>

                <!-- LAYER -->
                <div class="tp-caption sft"
                     data-x="center"
                     data-hoffset="0"
                     data-y="310"
                     data-speed="1600"
                     data-start="2800"
                     data-easing="Power4.easeOut"
                     data-endspeed="300"
                     data-endeasing="Power1.easeIn"
                     data-captionhidden="off"
                     style="z-index: 6">
                    <a href="http://www.ineluctable.net/killboard" class="btn-u btn-brd btn-brd-hover btn-u-light">View Killboard</a>
                </div>
            </li>
            <!-- END SLIDE -->

            <!-- SLIDE -->
            <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 3">
                <!-- MAIN IMAGE -->
                <img src="assets/img/sliders/eve3.jpg"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                <div class="tp-caption revolution-ch1 sft start"
                     data-x="center"
                     data-hoffset="0"
                     data-y="100"
                     data-speed="1500"
                     data-start="500"
                     data-easing="Back.easeInOut"
                     data-endeasing="Power1.easeIn"
                     data-endspeed="300">
                    Support for ISK generation
                </div>

                <!-- LAYER -->
                <div class="tp-caption revolution-ch2 sft"
                     data-x="center"
                     data-hoffset="0"
                     data-y="190"
                     data-speed="1400"
                     data-start="2000"
                     data-easing="Power4.easeOut"
                     data-endspeed="300"
                     data-endeasing="Power1.easeIn"
                     data-captionhidden="off"
                     style="z-index: 6">
                    We know how important it is to feed the pvp habit.<br/>
                    Help is provided to generate isk
                </div>

                <!-- LAYER -->
                <div class="tp-caption sft"
                     data-x="center"
                     data-hoffset="0"
                     data-y="310"
                     data-speed="1600"
                     data-start="2800"
                     data-easing="Power4.easeOut"
                     data-endspeed="300"
                     data-endeasing="Power1.easeIn"
                     data-captionhidden="off"
                     style="z-index: 6">
                    <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Member Corps</a>
                    <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Isk Generation options</a>
                </div>
            </li>
            <!-- END SLIDE -->
        </ul>
        <div class="tp-bannertimer tp-bottom"></div>
    </div>
</div>
<!--=== End Slider ===-->

<!--=== Alliance Leaders Block ===-->

<div class="container content">
    <div class="headline-center-v2 headline-center-v2-dark">
        <h2>Alliance Leadership</h2>
        <span class="bordered-icon"><i class="fa fa-th-large"></i></span>
    </div><!--/Headline Center V2-->
    <div class="row">
        <div class="col-md-3 content-boxes-v6 md-margin-bottom-50">
            <img src="http://image.eveonline.com/Character/925241548_128.jpg" class="img-circle">
            <h1 class="title-v3-md text-uppercase margin-bottom-10">Forsake Megellan</h1>
            <p>Alliance CEO</p>
        </div>
        <div class="col-md-3 content-boxes-v6 md-margin-bottom-50">
            <img src="http://image.eveonline.com/Character/697109132_128.jpg" class="img-circle">
            <h2 class="title-v3-md text-uppercase margin-bottom-10">Ace MacRou</h2>
            <p>Lead FC</p>
        </div>
        <div class="col-md-3 content-boxes-v6 md-margin-bottom-50">
            <img src="http://image.eveonline.com/Character/1217637063_128.jpg" class="img-circle">
            <h2 class="title-v3-md text-uppercase margin-bottom-10">Lentaqi Ap'raduz</h2>
            <p>Logistics lead</p>
        </div>
        <div class="col-md-3 content-boxes-v6">
            <img src="http://image.eveonline.com/Character/1201180832_128.jpg" class="img-circle">
            <h2 class="title-v3-md text-uppercase margin-bottom-10">Oodin</h2>
            <p>Web Admin</p>
        </div>

    </div><!--/row-->
</div><!--/container-->
<!--=== End Alliance Leaders Block ===-->

<!--=== Service Info ===-->
<div class="service-info margin-bottom-60">
    <div class="container">
        <div class="headline-center-v2 headline-center-v2-dark">
            {{--<h2>deidicated to eve online</h2>--}}
            <img src="assets/img/eve-logo-flare2.png" class="img-responsive">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="margin-bottom-30">
                    {{--<i class="service-info-icon rounded-x icon-wrench"></i>--}}
                    <div class="info-description">
                        <h3 class="title-v3-md text-uppercase">Skill-based RPG</h3>
                        <p>With hundreds of skills to choose from, EVE Online is the world's most open-ended sci-fi experience. Create a unique character to fit your goals and play style.</p>
                    </div>
                </div>
                <div class="margin-bottom-30">
                    {{--<i class="service-info-icon rounded-x icon-power"></i>--}}
                    <div class="info-description">
                        <h3 class="title-v3-md text-uppercase">Pulse-pounding combat</h3>
                        <p>Battle with hundreds of players as part of a massive fleet, fight with a tight-knit group, or roam the stars as a deadly solo pirate. Battle-ready players and NPCs are waiting through the next jump gate.</p>
                    </div>
                </div>
                <div class="md-margin-bottom-30">
                    {{--<i class="service-info-icon rounded-x icon-bell"></i>--}}
                    <div class="info-description">
                        <h3 class="title-v3-md text-uppercase">Cutting-edge graphics</h3>
                        <p>Graphics and audio are an important part of the virtual world experience. CCP is always updating sound and visuals to maintain the most modern, immersive sci-fi world.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="responsive-video">
                    <iframe width="854" height="510" src="https://www.youtube.com/embed/e2X1MIR1KMs" frameborder="0" allowfullscreen></iframe>
                    {{--<iframe src="//player.vimeo.com/video/78451097?title=0&amp;byline=0&amp;portrait=0&amp;badge=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>--}}
                </div>
            </div>
        </div><!--/row-->
    </div><!--/container-->
</div>
<!--=== End Service Info ===-->

@endsection

@section('scripts')

    <script type="text/javascript" src="assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery.parallax.js"></script>

    <script type="text/javascript" src="assets/js/revolution-slider.js"></script>

@endsection

@section('jqueryreadyfunction')
    App.initParallaxBg();
    RevolutionSlider.initRSfullWidth();
@endsection