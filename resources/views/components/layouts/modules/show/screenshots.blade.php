@props(['module'])

<div class="relative">
    <ovds-slider :screenshots="{{ json_encode($module->screenshots) }}" :arrow="true" :slider-view="5"></ovds-slider>
</div>
