<div class="formBlock" id="formBlock">
    <div><h2>Sign In</h2></div>
    <form id="formSignIn" method="post" action="">
        <div class="form-floating mb-3">
            <input type="login" class="form-control" name="login" id="loginIn" placeholder="login">
            <label for="floatingInput">Login</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="passwordIn" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div id="btnGroup">
            <button type="submit" class="btn btn-dark">Sign In</button>
            <button class="btn btn-dark" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFormRegistration" aria-expanded="false" aria-controls="collapseExample">
                Sign Up
            </button>
        </div>
    </form>
    <div class="collapse" id="collapseFormRegistration">
        <div><h2>Sign Up</h2></div>
        <form id="formRegistration" method="post" action="">
            <div class="form-floating mb-3">
                <input type="login" class="form-control" name="loginUp" id="loginUp" placeholder="Login" required>
                <label for="floatingInput">Login</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="passwordUp" id="passwordUp" placeholder="Password" required>
                <label for="floatingInput">Password</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" name="emailUp" id="emailUp" placeholder="name@example.com" required>
                <label for="floatingPassword">Email address</label>
            </div>
            <input type="hidden" name="signUp" value="signUp">
            <div id="btnGroup">
                <button type="submit" class="btn btn-dark">Registration</button>
            </div>
        </form>
    </div>
</div>
