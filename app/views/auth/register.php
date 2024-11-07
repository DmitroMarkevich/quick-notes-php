<div class="container vh-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="/static/img/notes.webp" class="img-fluid" alt="Notes images">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <h3 class="mb-4">Sign up</h3>

            <?php
            if (!empty($errors)): ?>
                <div class="alert alert-warning">
                    <ul class="mb-0">
                        <?php
                        foreach ($errors as $error): ?>
                            <li><?php
                                echo htmlspecialchars($error); ?></li>
                        <?php
                        endforeach; ?>
                    </ul>
                </div>
            <?php
            endif; ?>

            <form action="/register" method="post">
                <div class="form-floating mb-3">
                    <input type="email" id="email" class="form-control form-control-lg"
                           name="email" required minlength="5" maxlength="50">
                    <label class="form-label" for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" id="password" class="form-control form-control-lg"
                           name="password" required minlength="8" maxlength="100">
                    <label class="form-label" for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="fullName" class="form-control form-control-lg"
                           name="fullName">
                    <label class="form-label" for="fullName">Full name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="tel" id="phone" class="form-control form-control-lg"
                           name="phone" pattern="^\+\d{1,3}\s?\d{1,14}(?:x.+)?$" required>
                    <label class="form-label" for="phone">Phone</label>
                </div>
                <div class="text-center text-lg-start mt-3 pt-2 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                        Register
                    </button>
                    <p class="mb-0 ms-4 me-auto">Already have an account?</p>
                    <p class="mb-0 me-auto">
                        <a href="/login" class="link-danger">Sign in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>