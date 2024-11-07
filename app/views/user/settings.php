<main class="bd-main mb-3">
    <div class="container-fluid">
        <div class="container d-flex justify-content-center mt-5">
            <div class="col-md-12 col-xl-6 d-flex justify-content-center">
                <form action="/user/update" method="post" class="w-100" style="max-width: 600px;">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <label class="form-label me-2 mb-0">Email address:</label>
                            <p id="email" class="mb-0"
                               style="font-weight: 400; color: #007bff;"><?= $authenticatedUser->getEmail() ?></p>
                        </div>
                        <a href="#" class="text-decoration-underline">Change</a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="name">Full name</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="<?= $authenticatedUser->getFullName() ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control"
                               placeholder="Enter your phone number"
                               value="<?= $authenticatedUser->getPhone() ?>"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="aboutMe">About Me</label>
                        <textarea id="aboutMe" name="aboutMe" class="form-control" rows="3"
                                  placeholder="Tell us about yourself..."></textarea>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <a href="/note/list" class="btn btn-outline-danger m-1 float-start"
                           style="padding-left: 2.5rem; padding-right: 2.5rem;">Cancel</a>
                        <button type="submit" class="btn btn-outline-success float-end"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>