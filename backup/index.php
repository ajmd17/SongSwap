<!DOCTYPE html>
<html>
<body>


<!-- connect -->

<!-- Login -->

<form id='loginForm' action='login.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Login</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<br>
 
<label for='usernameLogin' >Username:</label>
<input type='text' name='usernameLogin' id='usernameLogin'  maxlength="50" />
<br>
 
<label for='passwordLogin' >Password:</label>
<input type='password' name='passwordLogin' id='usernameLogin' maxlength="50" />
<br>
 
<input id="button" type="submit" name='login' value='Log in' />
 
</fieldset>
</form>


<!-- Registration -->


<form id='registerForm' action='login.php' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Register new account</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
 
<label for='usernameRegister' >Username:</label>
<input type='text' name='usernameRegister' id='usernameRegister'  maxlength="50" />
<br>
 
<label for='passwordRegister' >Password:</label>
<input type='password' name='passwordRegister' id='passwordRegister' maxlength="50" />
<br>

<label for='passwordRegister2' >Password (again):</label>
<input type='password' name='passwordRegister2' id='passwordRegister2' maxlength="50" />
<br>

<label for='emailRegister' >Email:</label>
<input type='text' name='emailRegister' id='emailRegister' maxlength="50" />
<br>

<label for='emailRegister2' >Email (again):</label>
<input type='text' name='emailRegister2' id='emailRegister2' maxlength="50" />
<br>
 
<input id="button" type="submit" name='register' value='Register' />
 
</fieldset>
</form>



</body>
</html>