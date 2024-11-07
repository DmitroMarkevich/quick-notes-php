<div class="container vh-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="/static/img/notes.webp" class="img-fluid" alt="Notes images">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <h3 class="mb-4">Sign in</h3>
            <form action="/login" method="post">
                <div class="form-floating mb-3">
                    <input type="email" id="login-email" name="email"
                           class="form-control form-control-lg"
                           placeholder="Enter a valid email address" required minlength="5" maxlength="50">
                    <label for="login-email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" id="login-password" name="password"
                           class="form-control form-control-lg"
                           placeholder="Enter password" required minlength="8" maxlength="100">
                    <label for="login-password">Password</label>
                </div>
                <div class="text-center text-lg-start mt-2 pt-2 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                        Login
                    </button>
                    <p class="mb-0 ms-5 me-auto">Don't have an account?</p>
                    <p class="mb-0 me-auto">
                        <a href="/register" class="link-danger">Sign up</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
