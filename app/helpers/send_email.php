<?
if (!function_exists('ft_send_mail')) {
	function ft_send_mail($id,$to_email, $subject, $token , $username)
	{
		$body = '<div class="email-container" style="background-color: whitesmoke; width: 700px; height: 500px;padding: 20px;">
		<div class="title" style=\'color: #0C1117; text-align: center; font-family: billabong;font-size: 200%;\'><h1>Camagru</h1></div>
		<div class="welcome"><h2 style=\'color: #0C1117; text-align: left; font-family: "Gill Sans", sans-serif;\'>Welcome ' . $username . ',</h2></div>
		<div class="reset"><h3 style=\'color: #0C1117; text-align: left; font-family: "Gill Sans", sans-serif;\'>Verify your account</h3></div>
		<div class="body"><p style=\'color: #0C1117; text-align: left; font-family: "Gill Sans", sans-serif;\'>
		
		<br/>
	
		To verify your camagru account , please follow the link below:<br/>
		<a href="' . URLROOT . '/users/verification/' . $id ."/". $token . '">click here</a>
		<br/>
		<br/>

		<br/>
		<br/>
		The CAMAGRU Team.
		</p>
		</div>
		</div>';
		$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <no_reply@camagru.42>' . "\r\n";
		return mail($to_email, $subject, $body, $headers);
	}
}