<main class="bd-main mb-3">
    <div class="container-fluid">
        <section class="mb-5">
            <h1 class="my-5 text-center">My Notes</h1>
            <div class="row">
                <?php if (!empty($notes)) : ?>
                    <?php foreach ($notes as $note) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($note->getTitle()) ?></h5>
                                    <p class="card-text"><?= nl2br(htmlspecialchars($note->getContent())) ?></p>
                                    <span class="note-date d-block">Created: <?= $note->getCreatedAt()->format('d-m-Y H:i') ?></span>
                                    <span class="note-date d-block">Updated: <?= $note->getUpdatedAt()->format('d-m-Y H:i') ?></span>

                                    <?php if (strcasecmp($note->getAccessType(), 'public') === 0): ?>
                                        <span class="badge bg-success d-flex align-items-center">public</span>
                                    <?php elseif (strcasecmp($note->getAccessType(), 'private') === 0): ?>
                                        <span class="badge bg-danger d-flex align-items-center">private</span>
                                    <?php endif; ?>
                                </div>
                                <a href="/share" class="nav-link text-black d-flex align-items-center">
                                    <i class="bi bi-share me-2"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-center">No notes available.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div class="d-flex justify-content-center">
        <nav aria-label="Notes Pagination">
            <ul class="pagination notes-pagination">
                <?php if ($pagination_links) : ?>
                    <?= $pagination_links ?>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</main>