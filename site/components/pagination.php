<div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pagina=1">Primeira</a></li>
                    <?php if($pagina>1):?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina-1 ?>">&laquo;</a></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href=""><?= $pagina?></a></li>
                    <?php if($pagina<$paginas):?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina+1 ?>">&raquo;</a></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href="?pagina=<?= $paginas ?>">Última</a></li>
                </ul>
            </nav>
        </div>