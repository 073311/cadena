@stack('scripts_start')

<!-- <script type="text/javascript" src="{{ asset('public/ovds-js/hotkeys.js') }}" defer></script> -->

@stack('body_css')

@stack('body_stylesheet')

@stack('body_js')

@stack('body_scripts')

<script type="text/javascript" src="{{ asset('vendor/livewire/livewire/dist/livewire.min.js') }}" defer></script>

@stack('scripts_end')
