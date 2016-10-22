@if (count($data['company_list']) > 5)
<script>
    jQuery(document).ready(function ($) {

        var jssor_companies_thumbnail_options = {
          $AutoPlay: true,
          $AutoPlaySteps: 1,
          $SlideDuration: 160,
          $SlideWidth: 184,
          $SlideSpacing: 3,
          $Cols: 5,
          $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
            $Steps: 5
          },
          $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$,
            $SpacingX: 1,
            $SpacingY: 1
          }
        };

        var jssor_companies_thumbnail_slider = new $JssorSlider$("jssor_companies_thumbnail", jssor_companies_thumbnail_options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizing
        function ScaleCompThumbnailSlider() {
            var refSize = jssor_companies_thumbnail_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 929);
                jssor_companies_thumbnail_slider.$ScaleWidth(refSize);
            }
            else {
                window.setTimeout(ScaleCompThumbnailSlider, 10);
            }
        }
        ScaleCompThumbnailSlider();
        $(window).bind("load", ScaleCompThumbnailSlider);
        $(window).bind("resize", ScaleCompThumbnailSlider);
        $(window).bind("orientationchange", ScaleCompThumbnailSlider);
        //responsive code end
    });
</script>

<style>

    /* jssor slider bullet navigator skin 03 css */
    /*
    .jssorb03 div           (normal)
    .jssorb03 div:hover     (normal mouseover)
    .jssorb03 .av           (active)
    .jssorb03 .av:hover     (active mouseover)
    .jssorb03 .dn           (mousedown)
    */
    .jssorb03 {
        position: absolute;
    }
    .jssorb03 div, .jssorb03 div:hover, .jssorb03 .av {
        position: absolute;
        /* size of bullet elment */
        width: 21px;
        height: 21px;
        text-align: center;
        line-height: 21px;
        color: white;
        font-size: 12px;
        background: url('/common/image/slide/b03.png') no-repeat;
        overflow: hidden;
        cursor: pointer;
    }
    .jssorb03 div { background-position: -5px -4px; }
    .jssorb03 div:hover, .jssorb03 .av:hover { background-position: -35px -4px; }
    .jssorb03 .av { background-position: -65px -4px; }
    .jssorb03 .dn, .jssorb03 .dn:hover { background-position: -95px -4px; }

    /* jssor slider arrow navigator skin 03 css */
    /*
    .jssora03l                  (normal)
    .jssora03r                  (normal)
    .jssora03l:hover            (normal mouseover)
    .jssora03r:hover            (normal mouseover)
    .jssora03l.jssora03ldn      (mousedown)
    .jssora03r.jssora03rdn      (mousedown)
    */
    .jssora03l, .jssora03r {
        display: block;
        position: absolute;
        /* size of arrow element */
        width: 55px;
        height: 55px;
        cursor: pointer;
        background: url('/common/image/slide/a03.png') no-repeat;
        overflow: hidden;
    }
    .jssora03l { background-position: -3px -33px; }
    .jssora03r { background-position: -63px -33px; }
    .jssora03l:hover { background-position: -123px -33px; }
    .jssora03r:hover { background-position: -183px -33px; }
    .jssora03l.jssora03ldn { background-position: -243px -33px; }
    .jssora03r.jssora03rdn { background-position: -303px -33px; }
</style>
@endif

<div class="w3-container">
    <div class="w3-row">
        <p class="w3-leftbar w3-border-green"><a href="/doi-tac">Danh sách đối tác</a></p>
    </div>
    @if (count($data['company_list']) <= 5)
    <div class="w3-row">
        <div class="w3-col s12 m12 l12">
            @foreach ($data['company_list'] as $key => $company)
            <a href="/doi-tac/{{ $company->slug }}"><img data-u="image" src="{{ $company->thumbnail }}" alt="{{ $company->name }}" class="w3-hover-shadow"></a>&nbsp;
            @endforeach
        </div>
    </div>
    @else
    <div class="w3-row">
        <div class="w3-col s12 m12 l12">

            <div id="jssor_companies_thumbnail" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 929px; height: 60px; overflow: hidden; visibility: hidden;">
                <!-- Loading Screen -->
                <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                    <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                    <div style="position:absolute;display:block;background:url('/common/image/slide/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                </div>
                <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 100%; height: 60px; overflow: hidden;">
                    @foreach ($data['company_list'] as $key => $company)
                    <div style="display: none;">
                        <a href="/doi-tac/{{ $company->slug }}"><img data-u="image" src="{{ $company->thumbnail }}" alt="{{ $company->name }}"></a>
                    </div>
                    @endforeach
                </div>
                <!-- Bullet Navigator -->
                <div data-u="navigator" class="jssorb03" style="bottom:10px;right:10px;">
                    <!-- bullet navigator item prototype -->
                    <div data-u="prototype" style="width:21px;height:21px;">
                        <div data-u="numbertemplate"></div>
                    </div>
                </div>
                <!-- Arrow Navigator -->
                <span data-u="arrowleft" class="jssora03l" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
                <span data-u="arrowright" class="jssora03r" style="top:0px;right:8px;width:55px;height:55px;" data-autocenter="2"></span>
            </div>
        </div>
    </div>
    @endif
</div>
