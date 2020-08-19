<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Success</title>
	<link href="https://fonts.googleapis.com/css?family=Kanit:200" rel="stylesheet">
</head>
<style>
* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  padding: 0;
  margin: 0;
}

#success {
  position: relative;
  height: 100vh;
}

#success .success {
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
}

.success {
  max-width: 767px;
  width: 100%;
  line-height: 1.4;
  text-align: center;
  padding: 15px;
}

.success h2 {
  font-family: 'Kanit', sans-serif;
  font-size: 33px;
  font-weight: 200;
  text-transform: uppercase;
  margin-top: 0px;
  margin-bottom: 25px;
  letter-spacing: 3px;
}


.success p {
  font-family: 'Kanit', sans-serif;
  font-size: 20px;
  font-weight: 200;
  margin-top: 0px;
  margin-bottom: 25px;
}


.success a {
  font-family: 'Kanit', sans-serif;
  color: #5FA91D;
  font-weight: 200;
  text-decoration: none;
  border-radius: 2px;
}

.success-social>a {
  display: inline-block;
  height: 40px;
  line-height: 40px;
  width: 40px;
  font-size: 14px;
  color: #5FA91D;
  border: 1px solid #efefef;
  border-radius: 50%;
  margin: 3px;
  -webkit-transition: 0.2s all;
  transition: 0.2s all;
}
.success-social>a:hover {
  color: #fff;
  background-color: #5FA91D;
  border-color: #5FA91D;
}

@media only screen and (max-width: 480px) {

  .success h2 {
    font-size: 22px;
  }
}

</style>
<body>

	<div id="success">
		<div class="success">
			<h1 style="color:{{ session('color') }}!important;">&#10004;</h1>
			<h2 style="color:{{ session('color') }}!important;">{{ session('alert') }}</h2>
			<p>{{ session('message') }} <a href="#">Trở lại trang chủ </a></p>
		</div>
	</div>

</body>

</html>
