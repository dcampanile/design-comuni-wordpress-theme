<?php
    global $post, $posts;
    // Per selezionare i contenuti in evidenza tramite flag
    // $post_types = dci_get_post_types_grouped('documenti-e-dati');
    // $contenuti_evidenza = dci_get_highlighted_posts( $post_types, 6);

    //Per selezionare i contenuti in evidenza tramite configurazione
    $contenuti_evidenza = dci_get_option('contenuti_evidenziati','documenti');

    if (is_array($contenuti_evidenza) && count($contenuti_evidenza)) {
?>
<div class="container px-4">
    <h2 class="title-xxlarge mt-70 mb-4 mt-lg-40 pt-lg-2 mb-lg-40">In evidenza</h2>
    <div class="row pb-60">
        <?php foreach ($contenuti_evidenza as $post_id) { 
            $post = get_post($post_id);
            $description = dci_get_meta('descrizione_breve'); 
            $tipo_documento = get_the_terms($post->ID, 'tipi_documento')[0];
        ?>
            <div class="col-12 col-md-4">
                <div class="card-wrapper rounded shadow-sm border border-light">
                    <div class="card bg-none">
                        <div class="card-body">
                            <div class="categoryicon-top">
                            <svg class="icon icon-sm">
                                <use href="#it-file"></use>
                            </svg>
                            <span class="text fw-semibold">
                                <a href="<?php echo get_term_link($tipo_documento->term_id); ?>" aria-label="Vai a categoria <?php echo $tipo_documento->name; ?>" title="Vai a categoria <?php echo $tipo_documento->name; ?>"><?php echo $tipo_documento->name; ?></a></span>
                            </div>
                            <a href="<?php echo get_permalink(); ?>" aria-label="Vai a <?php echo the_title(); ?>" title="Vai a <?php echo the_title(); ?>">
                            <h3 class="card-title h5"><?php echo the_title(); ?></h3>
                            </a>
                            <p class="card-text"><?php echo $description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } ?>