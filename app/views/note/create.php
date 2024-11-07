<main class="bd-main mb-3 d-flex flex-column justify-content-center align-items-center">
    <div class="container-fluid ">
        <section class="mb-5">
            <h1 class="my-5 text-center">Add New Note</h1>
            <div class="row justify-content-center">
                <div class="col-12">
                    <form action="/note/create" method="post" class="edit-note-form px-5">
                        <div class="mb-4">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" minlength="5" maxlength="50"
                                   required>
                        </div>
                        <div class="mb-4">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" rows="10" name="content" id="content" minlength="5"
                                      maxlength="500" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="accessType" id="inlineRadio1"
                                       value="PUBLIC">
                                <label class="form-check-label" for="inlineRadio1">Public</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="accessType" id="inlineRadio2"
                                       value="PRIVATE" checked>
                                <label class="form-check-label" for="inlineRadio2">Private</label>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-outline-success m-1">Save</button>
                                <a href="/note/list" type="button" class="btn btn-outline-danger m-1">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (!empty($errors)): ?>
                        <div class="alert alert-danger">
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
                </div>
            </div>
        </section>
    </div>
</main>