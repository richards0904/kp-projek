<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Login</title>
        <link rel="stylesheet" href="css/login.css"">
    </head>
    <body>
        <div class="center">
            <form action="{{route('login')}}" method="post">
                @csrf
                <h1>Log in</h1>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" />
                <label for="password">Password</label>
                <input type="password" name="password" id="password" />
                @if ($errors->any())
                    <div style="color: red; border-radius: 10px;border: red solid 1px;">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li style="list-style-type: none; padding-left: 0">{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit">Log in</button>
            </form>
        </div>
    </body>
</html>
