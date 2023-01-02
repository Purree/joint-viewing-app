@extends('layouts.app')

@section('content')
    <div id="app"></div>
    <noscript>
        You have Javascript turned off in your browser.
        It's not supported.
        Try to update browser or turn JavaScript on.
        If you use the latest version of your browser, download Google Chrome.
    </noscript>
{{--    Compatibility check--}}
    <script>
        try {
            new Function('import("")')
        } catch (err) {
            document.write(
                'You have an old browser. ' +
                'It\'s not supported. ' +
                'Try to update browser or download Google Chrome.'
            )
        }
    </script>
@endsection
