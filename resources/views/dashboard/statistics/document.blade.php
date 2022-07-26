<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div>
        <h1>{{ __('admin.User Statistics') }}</h1>
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('admin.Title') }}</th>
                            <th>{{ __('admin.Statistics') }}</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>{{ __('logins') }}</td>
                            <td>{{ $logins }}</td>
                        </tr>

                        <tr>
                            <td>{{ __('LogOuts') }}</td>
                            <td>{{ $logout }}</td>
                        </tr>

                        <tr>
                            <td>{{ __('New Accounts') }}</td>
                            <td>{{ $register }}</td>
                        </tr>

                        <tr>
                            <td>{{ __('Top Vists Country') }}</td>
                            <td>
                                @foreach ($countries as $country)
                                    @php
                                        $countryName = empty($country->country) ? __('no Name') : $country->country;
                                    @endphp

                                    {!! $countryName . ' || ' . $country->total . '<br>' !!}
                                @endforeach

                            </td>
                        </tr>


                        <tr>
                            <td>{{ __('Top Active Users') }}</td>
                            <td>
                                @foreach ($topUsers as $key => $User)
                                    {!! ++$key . '-' . $User->name . '<br>' !!}
                                @endforeach

                            </td>
                        </tr>


                    </tbody>
                </table>
                <html-separator />
    </div>

</body>

</html>
