<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- cdn bootstrap --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  {{-- cdn fontawesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <title>Reset Password</title>
</head>

<body>
  <div class="container">
    <div class="text-center">
      <h6>Reset Password</h6>
      <p>link ini dikirimkan karena anda meminta untuk mengubah password akun anda</p>
      <p>jika anda tidak mearasa melakukan permintaan ini, </strong> abaikan email ini</strong></p>
    </div>
    <h3>klik link ganti password di <a href="{{ route('val_forgot', ['token' =>$token]) }}">sini</a></h3>
  </div>

  {{-- @dd($token) --}}
</body>

</html>